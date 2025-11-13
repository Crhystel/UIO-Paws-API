<?php

namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class AnimalPhotoController extends Controller
{
    /**
     * Guarda una nueva foto para un animal.
     */
    public function store(Request $request, Animal $animal)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        $file = $request->file('photo');
        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $path = 'animal-photos/' . $fileName;
        $manager = ImageManager::gd();
        $resizedImage = $manager->read($file)->cover(800, 600);
        Storage::disk('public')->put($path, (string) $resizedImage->encode());
        $photo = $animal->photos()->create([
            'image_url' => $path,
        ]);

        return response()->json($photo, 201);
    }

    /**
     * Actualiza una foto existente.
     */
    public function update(Request $request, AnimalPhoto $photo)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);
        Storage::disk('public')->delete($photo->image_url);
        $file = $request->file('photo');
        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $path = 'animal-photos/' . $fileName;
        $manager = ImageManager::gd();
        $resizedImage = $manager->read($file)->cover(800, 600);
        Storage::disk('public')->put($path, (string) $resizedImage->encode());
        $photo->update([
            'image_url' => $path,
        ]);

        return response()->json($photo);
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