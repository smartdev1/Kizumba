<?php

namespace App\Services;

use App\Models\IssuedTicket;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketService
{
    /**
     * Génère les tickets émis pour un paiement confirmé.
     * Décrémente le stock et crée un IssuedTicket par article.
     */
    public function issueTicketsForPayment(Payment $payment): array
    {
        $issued = [];

        DB::transaction(function () use ($payment, &$issued) {
            foreach ($payment->cart_items as $item) {
                $ticket = Ticket::where('slug', $item['slug'])->lockForUpdate()->firstOrFail();

                $quantity = (int) ($item['quantity'] ?? 1);

                if ($ticket->available_stock < $quantity) {
                    throw new \RuntimeException(
                        "Stock insuffisant pour le ticket « {$ticket->name} »"
                    );
                }

                for ($i = 0; $i < $quantity; $i++) {
                    $issuedTicket = IssuedTicket::create([
                        'uid'          => $this->generateUid(),
                        'payment_id'   => $payment->id,
                        'ticket_id'    => $ticket->id,
                        'ticket_name'  => $ticket->name,
                        'price_paid'   => $ticket->price,
                        'currency'     => $ticket->currency,
                        'holder_name'  => $payment->customer_name,
                        'holder_email' => $payment->customer_email,
                        'holder_phone' => $payment->customer_phone,
                        'status'       => 'active',
                        'email_sent'   => false,
                    ]);

                    $issued[] = $issuedTicket;
                }

                // Incrémenter le compteur sold
                $ticket->increment('sold', $quantity);
            }
        });

        return $issued;
    }

    /**
     * Vérifie la validité d'un ticket via son UID (pour scan QR).
     */
    public function validateTicketByUid(string $uid): array
    {
        $ticket = IssuedTicket::with('ticket', 'payment')->where('uid', $uid)->first();

        if (!$ticket) {
            return ['valid' => false, 'message' => 'Ticket introuvable'];
        }

        if ($ticket->status === 'used') {
            return [
                'valid'   => false,
                'message' => 'Ticket déjà utilisé le ' . $ticket->used_at?->format('d/m/Y H:i'),
                'ticket'  => $ticket,
            ];
        }

        if ($ticket->status === 'cancelled') {
            return ['valid' => false, 'message' => 'Ticket annulé', 'ticket' => $ticket];
        }

        return [
            'valid'   => true,
            'message' => 'Ticket valide',
            'ticket'  => $ticket,
        ];
    }

    /**
     * Marque un ticket comme utilisé.
     */
    public function markAsUsed(IssuedTicket $issuedTicket): void
    {
        $issuedTicket->update([
            'status'  => 'used',
            'used_at' => now(),
        ]);
    }

    /**
     * Génère un UID court et unique : PKC-XXXXXXXX
     */
    private function generateUid(): string
    {
        do {
            $uid = 'PKC-' . strtoupper(Str::random(8));
        } while (IssuedTicket::where('uid', $uid)->exists());

        return $uid;
    }
}
