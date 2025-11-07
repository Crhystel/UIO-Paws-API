<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    use HasFactory;

    protected $table = 'breeds';
    protected $primaryKey = 'id_breed';
    public $timestamps = false;

    protected $fillable = ['breed_name', 'id_species'];

    public function species()
    {
        return $this->belongsTo(Species::class, 'id_species');
    }
}