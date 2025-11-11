<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'medical_records';
    protected $primaryKey = 'id_medical_records';
    public $timestamps = false;

    protected $fillable = ['event_date', 'description', 'event_type', 'veterinarian_name', 'medication', 'id_animal'];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }
}