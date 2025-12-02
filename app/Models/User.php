<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'sanctum';
    protected $appends = ['profile_photo_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'email',
        'password_hash',
        'document_type',
        'document_number',
        'phone',
        'id_address',
        'is_active' ,
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];
    public $timestamps = true;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password_hash' => 'hashed',
            'password_hash' => 'hashed',
        ];
    }
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address');
    }
    public function donations()
    {
        return $this->hasMany(Donation::class, 'id_user');
    }
    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'id_user');
    }
    public function volunteerApplications()
    {
        return $this->hasMany(VolunteerApplication::class, 'id_user');
    }
    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class, 'id_user');
    }
    public function termAcceptances()
    {
        return $this->hasMany(UserTermAcceptance::class, 'id_user');
    }
    public function getProfilePhotoUrlAttribute(){
        if($this->profile_photo_path){
            return Storage::url($this->profile_photo_path);
        }
        return 'https://via.placeholder.com/150';
    }
}
