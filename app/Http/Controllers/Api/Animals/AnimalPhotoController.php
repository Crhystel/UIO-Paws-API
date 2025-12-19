<?php

namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use App\Traits\HandleImageUpload; //Trait

class AnimalPhotoController extends Controller
{
    use HandleImageUpload; //Uso del Trait
    /**
     * Guarda una nueva foto para un animal.
     */
    public function store(Request $request, Animal $animal)
    {
        $request->validate(['photo' => 'required|image|max:5120']);

        // Usamos el método del Trait para procesar la imagen
        $path = $this->uploadAndResize($request->file('photo'), 'animal-photos');

        $photo = $animal->photos()->create(['image_url' => $path]);
        return response()->json($photo, 201);
    }

    /**
     * Actualiza una foto existente.
     */
    public function update(Request $request, AnimalPhoto $photo)
    {
        $request->validate(['photo' => 'required|image|max:5120']);
        // Borramos la vieja usando el Trait
        $this->deleteFile($photo->image_url);
        // Subimos la nueva usando el Trait
        $path = $this->uploadAndResize($request->file('photo'), 'animal-photos');
        $photo->update(['image_url' => $path]);
        return response()->json($photo);
    }

    /**
     * Elimina una foto de un animal.
     */
    public function destroy(AnimalPhoto $photo)
    {
        // Borramos usando el Trait
        $this->deleteFile($photo->image_url);
        $photo->delete();
        return response()->json(null, 204);
    }
}