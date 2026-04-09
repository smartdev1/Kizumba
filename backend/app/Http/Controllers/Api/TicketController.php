<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * GET /api/tickets — liste des tickets actifs avec stock disponible
     */
    public function index(): JsonResponse
    {
        $tickets = Ticket::where('is_active', true)
            ->orderBy('price')
            ->get()
            ->map(fn ($t) => $this->format($t));

        return response()->json(['data' => $tickets]);
    }

    /**
     * GET /api/tickets/{slug} — détail d'un ticket
     */
    public function show(string $slug): JsonResponse
    {
        $ticket = Ticket::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return response()->json(['data' => $this->format($ticket)]);
    }

    private function format(Ticket $ticket): array
    {
        return [
            'id'              => $ticket->id,
            'slug'            => $ticket->slug,
            'name'            => $ticket->name,
            'description'     => $ticket->description,
            'category'        => $ticket->category,
            'price'           => $ticket->price,
            'currency'        => $ticket->currency,
            'includes'        => $ticket->includes ?? [],
            'available_stock' => $ticket->available_stock,
            'is_available'    => $ticket->isAvailable(),
        ];
    }
}
