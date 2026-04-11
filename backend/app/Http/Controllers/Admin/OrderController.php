<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TicketMail;
use App\Models\IssuedTicket;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * GET /admin/orders — liste des commandes avec pagination
     */
    public function index(Request $request): JsonResponse
    {
        $payments = Payment::with('issuedTickets')
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($request->query('search'), function ($q, $s) {
                $q->where('customer_email', 'like', "%{$s}%")
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('tx_ref', 'like', "%{$s}%");
            })
            ->orderByDesc('created_at')
            ->paginate(20);

        return response()->json($payments);
    }

    /**
     * GET /admin/orders/{tx_ref} — détail d'une commande
     */
    public function show(string $txRef): JsonResponse
    {
        $payment = Payment::with('issuedTickets.ticket')
            ->where('tx_ref', $txRef)
            ->firstOrFail();

        return response()->json(['data' => $payment]);
    }

    /**
     * POST /admin/orders/{tx_ref}/resend — renvoyer les tickets par email
     */
    public function resend(string $txRef): JsonResponse
    {
        $payment = Payment::where('tx_ref', $txRef)
            ->where('status', 'completed')
            ->with('issuedTickets')
            ->firstOrFail();

        $sent = 0;
        foreach ($payment->issuedTickets as $issuedTicket) {
            if ($issuedTicket->status === 'active') {
                Mail::to($payment->customer_email)->send(new TicketMail($issuedTicket));
                $issuedTicket->update(['email_sent' => true]);
                $sent++;
            }
        }

        return response()->json([
            'message'     => "{$sent} ticket(s) renvoyé(s) à {$payment->customer_email}",
            'sent_count'  => $sent,
        ]);
    }

    /**
     * GET /admin/tickets/validate/{uid} — scanner QR code
     */
    public function validateTicket(string $uid): JsonResponse
    {
        $issuedTicket = IssuedTicket::with('payment', 'ticket')
            ->where('uid', $uid)
            ->first();

        if (!$issuedTicket) {
            return response()->json(['valid' => false, 'message' => 'Ticket introuvable'], 404);
        }

        if ($issuedTicket->status === 'used') {
            return response()->json([
                'valid'   => false,
                'message' => 'Ticket déjà utilisé le ' . $issuedTicket->used_at?->format('d/m/Y H:i'),
                'ticket'  => $issuedTicket,
            ]);
        }

        if ($issuedTicket->status === 'cancelled') {
            return response()->json([
                'valid'   => false,
                'message' => 'Ticket annulé',
                'ticket'  => $issuedTicket,
            ]);
        }

        // Marquer comme utilisé
        $issuedTicket->update(['status' => 'used', 'used_at' => now()]);

        return response()->json([
            'valid'       => true,
            'message'     => 'Ticket valide — entrée enregistrée',
            'ticket'      => $issuedTicket->fresh(['payment', 'ticket']),
        ]);
    }
}
