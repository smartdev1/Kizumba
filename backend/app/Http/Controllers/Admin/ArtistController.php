<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function index(): JsonResponse
    {
        $artists = Artist::orderBy('category')
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        return response()->json(['data' => $artists]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|in:professeur,dj',
            'specialty'     => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'country_flag'  => 'nullable|string|max:10',
            'bio'           => 'nullable|string',
            'instagram'     => 'nullable|string|max:255',
            'is_active'     => 'boolean',
            'display_order' => 'integer|min:0',
            'image'         => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('artists', 'public');
        }

        unset($data['image']);
        $artist = Artist::create($data);

        return response()->json(['data' => $artist->fresh()], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $artist = Artist::findOrFail($id);

        $data = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'category'      => 'sometimes|in:professeur,dj',
            'specialty'     => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'country_flag'  => 'nullable|string|max:10',
            'bio'           => 'nullable|string',
            'instagram'     => 'nullable|string|max:255',
            'is_active'     => 'boolean',
            'display_order' => 'integer|min:0',
            'image'         => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($artist->image_path) {
                Storage::disk('public')->delete($artist->image_path);
            }
            $data['image_path'] = $request->file('image')
                ->store('artists', 'public');
        }

        unset($data['image']);
        $artist->update($data);

        return response()->json(['data' => $artist->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        $artist = Artist::findOrFail($id);

        if ($artist->image_path) {
            Storage::disk('public')->delete($artist->image_path);
        }

        $artist->delete();

        return response()->json(['message' => 'Artiste supprimé']);
    }

    public function toggle(int $id): JsonResponse
    {
        $artist = Artist::findOrFail($id);
        $artist->update(['is_active' => !$artist->is_active]);

        return response()->json(['data' => $artist->fresh()]);
    }
}
