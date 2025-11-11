<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    use HasFactory;

    protected $table = 'volunteer_applications';
    protected $primaryKey = 'id_volunteer_applications';
    public $timestamps = false;
    protected $fillable = ['motivation', 'application_date', 'id_user', 'id_status', 'reviewed_by_id_admin'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'id_status');
    }
}