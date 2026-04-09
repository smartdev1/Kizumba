<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Ticket;
use App\Services\PayDunyaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function __construct(private PayDunyaService $payDunya) {}

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
        ]);

        // Vérification stock + calcul montant
        $cartItems   = [];
        $totalAmount = 0;

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

            $cartItems[] = [
                'slug'        => $ticket->slug,
                'name'        => $ticket->name,
                'quantity'    => $item['quantity'],
                'unit_price'  => $ticket->price,
                'description' => $ticket->description ?? '',
            ];

            $totalAmount += $ticket->price * $item['quantity'];
        }

        $txRef = 'PKC-' . strtoupper(Str::random(12));

        // Enregistrement du paiement en attente
        $payment = Payment::create([
            'tx_ref'        => $txRef,
            'status'        => 'pending',
            'amount'        => $totalAmount,
            'currency'      => 'FCFA',
            'customer_name'  => $data['customer']['name'],
            'customer_email' => $data['customer']['email'],
            'customer_phone' => $data['customer']['phone'] ?? null,
            'cart_items'    => $cartItems,
        ]);

        // Création facture PayDunya
        try {
            $result = $this->payDunya->createInvoice([
                'tx_ref'       => $txRef,
                'amount'       => $totalAmount,
                'description'  => 'United Kizdom World Congress — Pass festival',
                'customer'     => $data['customer'],
                'items'        => $cartItems,
                'return_url'   => config('paydunya.return_url') . "?tx_ref={$txRef}",
                'cancel_url'   => config('paydunya.cancel_url'),
                'callback_url' => config('paydunya.callback_url'),
            ]);
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            Log::error('PayDunya initiate error', ['tx_ref' => $txRef, 'error' => $e->getMessage()]);

            return response()->json(['message' => 'Erreur lors de la création du paiement'], 500);
        }

        // Sauvegarde du token PayDunya
        $payment->update(['paydunya_token' => $result['token']]);

        return response()->json([
            'payment_url' => $result['payment_url'],
            'tx_ref'      => $txRef,
            'token'       => $result['token'],
        ]);
    }

    /**
     * GET /api/payments/{tx_ref}/status
     * Retourne le statut d'un paiement (utilisé par le frontend après retour).
     */
    public function status(string $txRef): JsonResponse
    {
        $payment = Payment::where('tx_ref', $txRef)
            ->with('issuedTickets')
            ->firstOrFail();

        return response()->json([
            'status'         => $payment->status,
            'amount'         => $payment->amount,
            'currency'       => $payment->currency,
            'customer_name'  => $payment->customer_name,
            'customer_email' => $payment->customer_email,
            'issued_tickets' => $payment->isCompleted()
                ? $payment->issuedTickets->map(fn ($t) => [
                    'uid'         => $t->uid,
                    'ticket_name' => $t->ticket_name,
                    'status'      => $t->status,
                ])
                : [],
        ]);
    }
}
