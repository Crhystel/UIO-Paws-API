<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerOpportunity extends Model
{
    use HasFactory;

    protected $table = 'volunteer_opportunities';
    protected $primaryKey = 'id_volunteer_opportunity';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'is_active',
    ];
    public function applications()
    {
        return $this->hasMany(VolunteerApplication::class, 'id_volunteer_opportunity');
    }
}