<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuedTicket;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * GET /admin/dashboard — KPIs globaux
     */
    public function index(): JsonResponse
    {
        $totalRevenue    = Payment::where('status', 'completed')->sum('amount');
        $totalOrders     = Payment::where('status', 'completed')->count();
        $totalTickets    = IssuedTicket::where('status', 'active')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        $ticketStats = Ticket::where('is_active', true)
            ->get()
            ->map(fn ($t) => [
                'id'              => $t->id,
                'name'            => $t->name,
                'category'        => $t->category,
                'price'           => $t->price,
                'stock'           => $t->stock,
                'sold'            => $t->sold,
                'available_stock' => $t->available_stock,
            ]);

        $recentPayments = Payment::where('status', 'completed')
            ->orderByDesc('paid_at')
            ->limit(10)
            ->get()
            ->map(fn ($p) => [
                'tx_ref'        => $p->tx_ref,
                'customer_name'  => $p->customer_name,
                'customer_email' => $p->customer_email,
                'amount'        => $p->amount,
                'currency'      => $p->currency,
                'paid_at'       => $p->paid_at?->toDateTimeString(),
                'tickets_count' => $p->issuedTickets()->count(),
            ]);

        return response()->json([
            'kpis' => [
                'total_revenue'    => $totalRevenue,
                'total_orders'     => $totalOrders,
                'total_tickets'    => $totalTickets,
                'pending_payments' => $pendingPayments,
            ],
            'ticket_stats'    => $ticketStats,
            'recent_payments' => $recentPayments,
        ]);
    }
}
