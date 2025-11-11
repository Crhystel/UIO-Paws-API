<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationApplication extends Model
{
    use HasFactory;

    protected $table = 'donation_applications';
    protected $primaryKey = 'id_donation_application';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'application_date',
        'id_status',
        'reviewed_by_id_admin',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'id_status');
    }
    public function items()
    {
        return $this->belongsToMany(
            DonationItemsCatalog::class,
            'donation_application_items',      
            'id_donation_application',         
            'id_donation_item_catalog'       
        )->withPivot('quantity');
    }
}