<?php

namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalPhotoController extends Controller
{
    /**
     * Guarda una nueva foto para un animal.
     */
    public function store(Request $request, Animal $animal)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $path = $request->file('photo')->store('animal-photos', 'public');
        $photo = $animal->photos()->create([
            'image_url' => $path,
        ]);

        return response()->json($photo, 201);
    }

    /**
     * Elimina una foto de un animal.
     */
    public function destroy(AnimalPhoto $photo)
    {
        Storage::disk('public')->delete($photo->image_url);
        $photo->delete();

        return response()->json(null, 204);
    }
}