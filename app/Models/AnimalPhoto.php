<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AnimalPhoto extends Model
{
    use HasFactory;

    protected $table = 'animal_photos';
    protected $primaryKey = 'id_animal_photos';
    public $timestamps = false;
    protected $appends = ['full_image_url'];

    protected $fillable = ['image_url', 'id_animal'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }
    public function getFullImageUrlAttribute()
    {
        return Storage::url($this->image_url);
    }
}