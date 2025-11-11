<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model{
    use HasFactory;
    protected $table='adoption_applications';
    protected $primaryKey='id_adoption_application';
    public $timestamps = true;
    protected $fillable=[
        'application_date',
        'id_user',
        'id_animal',
        'id_status',
        'approved_by_id_admin',
        'admin_notes',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'id_status');
    }

    public function homeInformation()
    {
        return $this->hasOne(HomeInformation::class, 'id_adoption_application');
    }
}