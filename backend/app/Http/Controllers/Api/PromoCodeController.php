<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    /**
     * POST /api/promo-codes/validate
     *
     * Valide un code promo contre un panier d'articles.
     * Retourne le détail des réductions applicables par ticket.
     *
     * Body: { "code": "UKWC2026", "items": [{ "slug": "full-pass", "quantity": 1 }] }
     */
    public function validate(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code'           => 'required|string|max:50',
            'items'          => 'required|array|min:1',
            'items.*.slug'   => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $promo = PromoCode::where('code', strtoupper(trim($data['code'])))->first();

        if (!$promo) {
            return response()->json(['valid' => false, 'message' => 'Code promo invalide.'], 422);
        }

        if (!$promo->isUsable()) {
            if ($promo->expires_at && now()->isAfter($promo->expires_at)) {
                return response()->json(['valid' => false, 'message' => 'Ce code promo a expiré.'], 422);
            }
            if ($promo->max_uses !== null && $promo->uses_count >= $promo->max_uses) {
                return response()->json(['valid' => false, 'message' => 'Ce code promo a atteint son nombre maximal d\'utilisations.'], 422);
            }
            return response()->json(['valid' => false, 'message' => 'Ce code promo n\'est pas actif.'], 422);
        }

        // Calcul des réductions par ticket
        $lineDiscounts    = [];
        $totalDiscount    = 0;
        $skippedEarlyBird = [];

        foreach ($data['items'] as $item) {
            $ticket = Ticket::where('slug', $item['slug'])->where('is_active', true)->first();

            if (!$ticket) continue;

            // Règle : pas de code promo sur un ticket en early bird
            if ($ticket->isEarlyBird()) {
                $skippedEarlyBird[] = $ticket->name;
                $lineDiscounts[] = [
                    'slug'          => $ticket->slug,
                    'name'          => $ticket->name,
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $ticket->effective_price,
                    'discount'      => 0,
                    'final_price'   => $ticket->effective_price,
                    'is_early_bird' => true,
                ];
                continue;
            }

            if (!$promo->appliesToSlug($ticket->slug)) {
                $lineDiscounts[] = [
                    'slug'          => $ticket->slug,
                    'name'          => $ticket->name,
                    'quantity'      => $item['quantity'],
                    'unit_price'    => $ticket->price,
                    'discount'      => 0,
                    'final_price'   => $ticket->price,
                    'is_early_bird' => false,
                ];
                continue;
            }

            $discount    = $promo->computeDiscount($ticket->price);
            $finalPrice  = $ticket->price - $discount;
            $totalDiscount += $discount * $item['quantity'];

            $lineDiscounts[] = [
                'slug'          => $ticket->slug,
                'name'          => $ticket->name,
                'quantity'      => $item['quantity'],
                'unit_price'    => $ticket->price,
                'discount'      => $discount,
                'final_price'   => $finalPrice,
                'is_early_bird' => false,
            ];
        }

        if ($totalDiscount === 0) {
            $msg = !empty($skippedEarlyBird)
                ? 'Ce code promo ne s\'applique pas aux billets en Early Bird.'
                : 'Ce code promo ne s\'applique à aucun article de votre panier.';

            return response()->json(['valid' => false, 'message' => $msg], 422);
        }

        return response()->json([
            'valid'          => true,
            'code'           => $promo->code,
            'type'           => $promo->type,
            'value'          => $promo->value,
            'description'    => $promo->description,
            'total_discount' => $totalDiscount,
            'lines'          => $lineDiscounts,
            'early_bird_skipped' => $skippedEarlyBird,
        ]);
    }
}
