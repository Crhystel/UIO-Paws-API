<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model{
    use HasFactory;
    protected $table='animals';
    protected $primaryKey='id_animal';
    public $timestamps = false;
    protected $fillable=[
        'animal_name',
        'status',
        'birth_date',
        'color',
        'is_sterilized',
        'description',
        'id_breed',
        'id_shelter',
        'sex',
        'age',
        'size',
    ];
    protected $casts = [
        'is_sterilized' => 'boolean',
    ];

    public function breed()
    {
        return $this->belongsTo(Breed::class, 'id_breed');
    }

    public function shelter()
    {
        return $this->belongsTo(Shelter::class, 'id_shelter');
    }

    public function photos()
    {
        return $this->hasMany(AnimalPhoto::class, 'id_animal');
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'id_animal');
    }
}