<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalPhoto extends Model
{
    use HasFactory;

    protected $table = 'animal_photos';
    protected $primaryKey = 'id_animal_photos';
    public $timestamps = false;

    protected $fillable = ['image_url', 'id_animal'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }
}