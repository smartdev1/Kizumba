<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PromoCodeAdminController extends Controller
{
    public function index(): JsonResponse
    {
        $codes = PromoCode::orderByDesc('created_at')->get();
        return response()->json(['data' => $codes]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code'              => 'required|string|max:50|unique:promo_codes,code',
            'type'              => 'required|in:percentage,fixed',
            'value'             => 'required|integer|min:1',
            'max_uses'          => 'nullable|integer|min:1',
            'starts_at'         => 'nullable|date',
            'expires_at'        => 'nullable|date|after_or_equal:starts_at',
            'is_active'         => 'boolean',
            'applicable_slugs'  => 'nullable|array',
            'applicable_slugs.*'=> 'string',
            'description'       => 'nullable|string|max:255',
        ]);

        // Forcer le code en majuscules
        $data['code'] = strtoupper(trim($data['code']));

        // Validation supplémentaire pour percentage
        if ($data['type'] === 'percentage' && $data['value'] > 100) {
            return response()->json(['message' => 'La valeur d\'un pourcentage ne peut pas dépasser 100.'], 422);
        }

        $promo = PromoCode::create($data);
        return response()->json(['data' => $promo], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $promo = PromoCode::findOrFail($id);

        $data = $request->validate([
            'code'              => 'sometimes|string|max:50|unique:promo_codes,code,' . $id,
            'type'              => 'sometimes|in:percentage,fixed',
            'value'             => 'sometimes|integer|min:1',
            'max_uses'          => 'nullable|integer|min:1',
            'starts_at'         => 'nullable|date',
            'expires_at'        => 'nullable|date',
            'is_active'         => 'boolean',
            'applicable_slugs'  => 'nullable|array',
            'applicable_slugs.*'=> 'string',
            'description'       => 'nullable|string|max:255',
        ]);

        if (isset($data['code'])) {
            $data['code'] = strtoupper(trim($data['code']));
        }

        $promo->update($data);
        return response()->json(['data' => $promo]);
    }

    public function destroy(int $id): JsonResponse
    {
        PromoCode::findOrFail($id)->delete();
        return response()->json(['message' => 'Code promo supprimé.']);
    }

    public function toggle(int $id): JsonResponse
    {
        $promo = PromoCode::findOrFail($id);
        $promo->update(['is_active' => !$promo->is_active]);
        return response()->json(['data' => $promo]);
    }
}
