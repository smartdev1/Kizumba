<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketAdminController extends Controller
{
    public function index(): JsonResponse
    {
        $tickets = Ticket::orderBy('category')->orderBy('price')->get()
            ->map(fn ($t) => array_merge($t->toArray(), [
                'image_url' => $t->image_path ? asset('storage/' . $t->image_path) : null,
                'available_stock' => $t->available_stock,
            ]));

        return response()->json(['data' => $tickets]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'                 => 'required|string|max:255',
            'subtitle'             => 'nullable|string|max:255',
            'description'          => 'nullable|string',
            'category'             => 'required|string|max:100',
            'price'                => 'required|integer|min:0',
            'currency'             => 'required|string|max:10',
            'includes'             => 'nullable|array',
            'stock'                => 'required|integer|min:0',
            'is_active'            => 'boolean',
            'image'                => 'nullable|image|max:4096',
            'early_bird_price'     => 'nullable|integer|min:0',
            'early_bird_starts_at' => 'nullable|date',
            'early_bird_ends_at'   => 'nullable|date|after_or_equal:early_bird_starts_at',
        ]);

        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);
        $data['sold'] = 0;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('tickets', 'public');
        }

        unset($data['image']);
        $ticket = Ticket::create($data);

        return response()->json([
            'data' => array_merge($ticket->fresh()->toArray(), [
                'image_url' => $ticket->image_path ? asset('storage/' . $ticket->image_path) : null,
            ])
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);

        $data = $request->validate([
            'name'                 => 'sometimes|string|max:255',
            'subtitle'             => 'nullable|string|max:255',
            'description'          => 'nullable|string',
            'category'             => 'sometimes|string|max:100',
            'price'                => 'sometimes|integer|min:0',
            'currency'             => 'sometimes|string|max:10',
            'includes'             => 'nullable|array',
            'stock'                => 'sometimes|integer|min:0',
            'is_active'            => 'boolean',
            'image'                => 'nullable|image|max:4096',
            'early_bird_price'     => 'nullable|integer|min:0',
            'early_bird_starts_at' => 'nullable|date',
            'early_bird_ends_at'   => 'nullable|date',
        ]);

        // Permettre d'effacer l'early bird en envoyant des chaînes vides
        if (array_key_exists('early_bird_price', $data) && $data['early_bird_price'] === '') {
            $data['early_bird_price'] = null;
        }
        if (array_key_exists('early_bird_starts_at', $data) && $data['early_bird_starts_at'] === '') {
            $data['early_bird_starts_at'] = null;
        }
        if (array_key_exists('early_bird_ends_at', $data) && $data['early_bird_ends_at'] === '') {
            $data['early_bird_ends_at'] = null;
        }

        if (isset($data['stock']) && $data['stock'] < $ticket->sold) {
            return response()->json([
                'message' => "Stock ne peut pas être inférieur aux billets vendus ({$ticket->sold})",
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($ticket->image_path) {
                Storage::disk('public')->delete($ticket->image_path);
            }
            $data['image_path'] = $request->file('image')->store('tickets', 'public');
        }

        unset($data['image']);
        $ticket->update($data);

        return response()->json([
            'data' => array_merge($ticket->fresh()->toArray(), [
                'image_url' => $ticket->image_path ? asset('storage/' . $ticket->image_path) : null,
                'available_stock' => $ticket->fresh()->available_stock,
            ])
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);

        if ($ticket->sold > 0) {
            return response()->json([
                'message' => 'Impossible de supprimer un billet déjà vendu. Désactivez-le à la place.',
            ], 422);
        }

        if ($ticket->image_path) {
            Storage::disk('public')->delete($ticket->image_path);
        }

        $ticket->delete();

        return response()->json(['message' => 'Billet supprimé']);
    }

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

    public function toggle(int $id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->update(['is_active' => !$ticket->is_active]);

        return response()->json(['data' => $ticket->fresh()]);
    }
}
