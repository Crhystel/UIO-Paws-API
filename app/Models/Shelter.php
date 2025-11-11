<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelter extends Model
{
    use HasFactory;

    protected $table = 'shelters';
    protected $primaryKey = 'id_shelter';
    public $timestamps = true;

    protected $fillable = ['shelter_name', 'contact_email', 'phone', 'description', 'id_address'];

    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address');
    }
}