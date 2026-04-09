<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    /**
     * GET /admin/tickets — tous les tickets (admin)
     */
    public function index(): JsonResponse
    {
        $tickets = Ticket::orderBy('category')->orderBy('price')->get();

        return response()->json(['data' => $tickets]);
    }

    /**
     * PUT /admin/tickets/{id}/stock — mettre à jour le stock
     */
    public function updateStock(Request $request, int $id): JsonResponse
    {
        $data   = $request->validate(['stock' => 'required|integer|min:0']);
        $ticket = Ticket::findOrFail($id);

        if ($data['stock'] < $ticket->sold) {
            return response()->json([
                'message' => "Stock ne peut pas être inférieur aux billets vendus ({$ticket->sold})",
            ], 422);
        }

        $ticket->update(['stock' => $data['stock']]);

        return response()->json(['data' => $ticket->fresh()]);
    }

    /**
     * PATCH /admin/tickets/{id}/toggle — activer/désactiver
     */
    public function toggle(int $id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['is_active' => !$ticket->is_active]);

        return response()->json(['data' => $ticket->fresh()]);
    }
}
