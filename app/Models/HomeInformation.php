<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeInformation extends Model
{
    use HasFactory;

    protected $table = 'home_information';
    protected $primaryKey = 'id_home_info';
    public $timestamps = false;

    protected $fillable = [
        'id_adoption_application', 'dwelling_type', 'has_yard', 'yard_enclosure_type', 'wall_material',
        'floor_material', 'room_count', 'bathroom_count', 'adults_in_home', 'has_balcony',
        'current_pet_count', 'others_pets_description', 'all_members_agree', 'previous_pets_history',
        'motivation_for_adoption', 'hours_pet_will_be_alone', 'location_when_alone', 'exercise_plan',
        'vacation_emergency_plan', 'behavioral_issue_plan', 'vet_reference_name', 'vet_reference_phone'
    ];

    public function adoptionApplication()
    {
        return $this->belongsTo(AdoptionApplication::class, 'id_adoption_application');
    }
}