<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketMail;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Models\Ticket;
use App\Services\PayDunyaService;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function __construct(
        private PayDunyaService $payDunya,
        private TicketService $ticketService,
    ) {}

    /**
     * POST /api/payments/initiate
     * Crée une transaction PayDunya et retourne l'URL de paiement.
     */
    public function initiate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'customer.name'    => 'required|string|max:100',
            'customer.email'   => 'required|email|max:150',
            'customer.phone'   => 'nullable|string|max:20',
            'items'            => 'required|array|min:1',
            'items.*.slug'     => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'promo_code'       => 'nullable|string|max:50',
        ]);

        // ── Résolution du code promo ──────────────────────────────────────────
        $promo = null;
        if (!empty($data['promo_code'])) {
            $promo = PromoCode::where('code', strtoupper(trim($data['promo_code'])))->first();

            if (!$promo || !$promo->isUsable()) {
                throw ValidationException::withMessages([
                    'promo_code' => ['Code promo invalide ou expiré.'],
                ]);
            }
        }

        // ── Vérification stock + calcul montant avec réductions ───────────────
        $cartItems     = [];
        $totalAmount   = 0;
        $totalDiscount = 0;

        foreach ($data['items'] as $item) {
            $ticket = Ticket::where('slug', $item['slug'])->where('is_active', true)->first();

            if (!$ticket) {
                throw ValidationException::withMessages([
                    'items' => ["Ticket « {$item['slug']} » introuvable ou inactif"],
                ]);
            }

            if ($ticket->available_stock < $item['quantity']) {
                throw ValidationException::withMessages([
                    'items' => ["Stock insuffisant pour « {$ticket->name} » (disponible : {$ticket->available_stock})"],
                ]);
            }

            $isEarlyBird = $ticket->isEarlyBird();
            $basePrice   = $ticket->effective_price; // early bird ou prix normal

            // Le code promo ne s'applique pas aux tickets en early bird
            $discount   = 0;
            $finalPrice = $basePrice;

            if ($promo && !$isEarlyBird && $promo->appliesToSlug($ticket->slug)) {
                $discount   = $promo->computeDiscount($basePrice);
                $finalPrice = $basePrice - $discount;
            }

            $totalAmount   += $finalPrice * $item['quantity'];
            $totalDiscount += $discount * $item['quantity'];

            $cartItems[] = [
                'slug'          => $ticket->slug,
                'name'          => $ticket->name,
                'quantity'      => $item['quantity'],
                'unit_price'    => $basePrice,
                'discount'      => $discount,
                'final_price'   => $finalPrice,
                'is_early_bird' => $isEarlyBird,
                'description'   => $ticket->description ?? '',
            ];
        }

        $txRef = 'PKC-' . strtoupper(Str::random(12));

        // ── Enregistrement du paiement en attente ─────────────────────────────
        $payment = Payment::create([
            'tx_ref'          => $txRef,
            'status'          => 'pending',
            'amount'          => $totalAmount,
            'currency'        => 'FCFA',
            'customer_name'   => $data['customer']['name'],
            'customer_email'  => $data['customer']['email'],
            'customer_phone'  => $data['customer']['phone'] ?? null,
            'cart_items'      => $cartItems,
            'promo_code_id'   => $promo?->id,
            'discount_amount' => $totalDiscount,
        ]);

        // ── Création facture PayDunya (prix finaux après réductions) ──────────
        $paydunyaItems = array_map(fn ($i) => [
            'slug'        => $i['slug'],
            'name'        => $i['name'],
            'quantity'    => $i['quantity'],
            'unit_price'  => $i['final_price'],
            'description' => $i['description'],
        ], $cartItems);

        try {
            $result = $this->payDunya->createInvoice([
                'tx_ref'       => $txRef,
                'amount'       => $totalAmount,
                'description'  => 'United Kizdom World Congress — Pass festival',
                'customer'     => $data['customer'],
                'items'        => $paydunyaItems,
                'return_url'   => config('paydunya.return_url') . "?tx_ref={$txRef}",
                'cancel_url'   => config('paydunya.cancel_url'),
                'callback_url' => config('paydunya.callback_url'),
            ]);
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            Log::error('PayDunya initiate error', ['tx_ref' => $txRef, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Erreur lors de la création du paiement'], 500);
        }

        $payment->update(['paydunya_token' => $result['token']]);

        return response()->json([
            'payment_url'     => $result['payment_url'],
            'tx_ref'          => $txRef,
            'token'           => $result['token'],
            'total_amount'    => $totalAmount,
            'discount_amount' => $totalDiscount,
        ]);
    }

    /**
     * POST /api/payments/{tx_ref}/status
     * Retourne le statut d'un paiement (utilisé par le frontend après retour).
     * L'email du client est requis pour prévenir l'énumération (IDOR).
     * Fallback actif : si le paiement est encore pending, on vérifie directement
     * chez PayDunya — utile quand le webhook IPN n'a pas été reçu (ngrok expiré, etc.).
     */
    public function status(Request $request, string $txRef): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $payment = Payment::where('tx_ref', $txRef)
            ->where('customer_email', strtolower(trim($request->input('email'))))
            ->with('issuedTickets')
            ->firstOrFail();

        if ($payment->status === 'pending' && $payment->paydunya_token) {
            $this->tryFallbackConfirmation($payment);
            $payment->refresh()->load('issuedTickets');
        }

        return response()->json([
            'status'   => $payment->status,
            'amount'   => $payment->amount,
            'currency' => $payment->currency,
            'issued_tickets' => $payment->isCompleted()
                ? $payment->issuedTickets->map(fn ($t) => [
                    'uid'         => $t->uid,
                    'ticket_name' => $t->ticket_name,
                    'status'      => $t->status,
                ])
                : [],
        ]);
    }

    /**
     * Vérifie le statut PayDunya et traite le paiement si complété.
     * Idempotent : ne re-émet pas de tickets si déjà émis.
     */
    private function tryFallbackConfirmation(Payment $payment): void
    {
        try {
            $verification = $this->payDunya->verifyInvoice($payment->paydunya_token);
        } catch (\Exception $e) {
            Log::warning('PaymentController fallback: vérification échouée', [
                'tx_ref' => $payment->tx_ref,
                'error'  => $e->getMessage(),
            ]);
            return;
        }

        if (!$verification['completed']) {
            return;
        }

        // Idempotence : ne pas retraiter si déjà complété entre-temps
        if ($payment->isCompleted()) {
            return;
        }

        $payment->update([
            'status'            => 'completed',
            'paid_at'           => now(),
            'paydunya_response' => $verification['raw'],
        ]);

        try {
            $issuedTickets = $this->ticketService->issueTicketsForPayment($payment);
        } catch (\Exception $e) {
            Log::error('PaymentController fallback: émission tickets échouée', [
                'tx_ref' => $payment->tx_ref,
                'error'  => $e->getMessage(),
            ]);
            return;
        }

        foreach ($issuedTickets as $issuedTicket) {
            try {
                Mail::to($payment->customer_email)->send(new TicketMail($issuedTicket));
                $issuedTicket->update(['email_sent' => true]);
            } catch (\Exception $e) {
                Log::error('PaymentController fallback: envoi email échoué', [
                    'uid'   => $issuedTicket->uid,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('PaymentController fallback: paiement traité avec succès', [
            'tx_ref'          => $payment->tx_ref,
            'tickets_emitted' => count($issuedTickets),
        ]);
    }
}
