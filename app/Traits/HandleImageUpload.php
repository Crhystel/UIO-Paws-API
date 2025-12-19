<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// TRAIT: HandleImageUpload
// Reutiliza la lógica de procesamiento de imágenes en cualquier controlador
trait HandleImageUpload
{
    public function uploadAndResize($file, $path = 'uploads')
    {
        $manager = new ImageManager(new Driver());
        $fileName = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $fullPath = $path . '/' . $fileName;
        $image = $manager->read($file)->cover(800, 600);
        Storage::disk('public')->put($fullPath, (string) $image->encode());

        return $fullPath;
    }

    public function deleteFile($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}