<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $table = 'emergency_contacts';
    protected $primaryKey = 'id_emergency_contacts';
    public $timestamps = false;

    protected $fillable = ['id_user', 'contact_name', 'contact_phone', 'relationship'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}