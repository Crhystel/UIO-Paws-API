<?php
namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Http\Requests\Animals\PhotoRequest;
use App\Models\Animal;
use App\Models\AnimalPhoto;
use App\Traits\HandleImageUpload;

class AnimalPhotoController extends Controller
{
    use HandleImageUpload;

    public function store(PhotoRequest $request, Animal $animal) {
        // El FormRequest ya validó que sea una imagen
        $path = $this->uploadAndResize($request->file('photo'), 'animal-photos');
        $photo = $animal->photos()->create(['image_url' => $path]);
        
        return response()->json($photo, 201);
    }

    public function update(PhotoRequest $request, AnimalPhoto $photo) {
        $this->deleteFile($photo->image_url);
        $path = $this->uploadAndResize($request->file('photo'), 'animal-photos');
        
        $photo->update(['image_url' => $path]);
        return response()->json($photo);
    }

    public function destroy(AnimalPhoto $photo) {
        $this->deleteFile($photo->image_url);
        $photo->delete();
        return response()->json(null, 204);
    }
}