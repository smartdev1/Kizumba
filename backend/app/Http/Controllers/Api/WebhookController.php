<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\TicketMail;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Services\PayDunyaService;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WebhookController extends Controller
{
    public function __construct(
        private PayDunyaService $payDunya,
        private TicketService $ticketService,
    ) {}

    /**
     * POST /api/webhooks/paydunya
     * IPN PayDunya — toujours répondre 200 pour éviter les retentatives
     */
    public function paydunya(Request $request): Response
    {
        // Restriction par IP des serveurs PayDunya
        $allowedIps = array_filter(
            explode(',', config('paydunya.webhook_ips', ''))
        );

        if (!empty($allowedIps) && !in_array($request->ip(), $allowedIps, true)) {
            Log::warning('PayDunya webhook: IP non autorisée', ['ip' => $request->ip()]);
            return response('forbidden', 403);
        }

        // PayDunya envoie le token dans data.token (corps JSON) ou via query string
        $token = $request->input('data.token') ?? $request->query('data');

        if (!$token) {
            Log::warning('PayDunya webhook: token manquant');
            return response('token missing', 200);
        }

        try {
            $verification = $this->payDunya->verifyInvoice($token);
        } catch (\Exception $e) {
            Log::error('PayDunya webhook: erreur vérification', ['token' => $token, 'error' => $e->getMessage()]);
            return response('verification error', 200);
        }

        if (!$verification['completed']) {
            Log::info('PayDunya webhook: paiement non complété', ['token' => $token, 'status' => $verification['status']]);
            return response('not completed', 200);
        }

        $raw    = $verification['raw'];
        $txRef  = $raw['custom_data']['tx_ref'] ?? null;

        if (!$txRef) {
            Log::error('PayDunya webhook: tx_ref absent', ['token' => $token]);
            return response('tx_ref missing', 200);
        }

        $payment = Payment::where('tx_ref', $txRef)->first();

        if (!$payment) {
            Log::error('PayDunya webhook: paiement introuvable', ['tx_ref' => $txRef]);
            return response('payment not found', 200);
        }

        // Idempotence — ne pas retraiter un paiement déjà complété
        if ($payment->isCompleted()) {
            return response('already processed', 200);
        }

        // Marquer le paiement comme complété
        $payment->update([
            'status'             => 'completed',
            'paid_at'            => now(),
            'paydunya_response'  => $raw,
        ]);

        // Émettre les tickets
        try {
            $issuedTickets = $this->ticketService->issueTicketsForPayment($payment);
        } catch (\Exception $e) {
            Log::error('PayDunya webhook: émission tickets échouée', [
                'tx_ref' => $txRef,
                'error'  => $e->getMessage(),
            ]);
            return response('ticket issue error', 200);
        }

        // Incrémenter le compteur d'utilisations du code promo
        if ($payment->promo_code_id) {
            PromoCode::where('id', $payment->promo_code_id)->increment('uses_count');
        }

        // Envoyer les emails
        foreach ($issuedTickets as $issuedTicket) {
            try {
                Mail::to($payment->customer_email)->send(new TicketMail($issuedTicket));
                $issuedTicket->update(['email_sent' => true]);
            } catch (\Exception $e) {
                Log::error('PayDunya webhook: envoi email échoué', [
                    'uid'   => $issuedTicket->uid,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('PayDunya webhook traité avec succès', [
            'tx_ref'          => $txRef,
            'tickets_emitted' => count($issuedTickets),
        ]);

        return response('ok', 200);
    }
}
