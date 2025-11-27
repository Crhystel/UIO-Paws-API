<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItemsCatalog extends Model
{
    use HasFactory;

    protected $table = 'donation_items_catalog';
    protected $primaryKey = 'id_donation_item_catalog';
    public $timestamps = false;

    protected $fillable = [
        'item_name', 
        'description', 
        'category', 
        'quantity_needed', 
        'id_shelter'
    ];
    
    public function shelter()
    {
        return $this->belongsTo(\App\Models\Shelter::class, 'id_shelter');
    }
    public function applications()
    {
        return $this->belongsToMany(
            DonationApplication::class, 
            'donation_application_items', 
            'id_donation_item_catalog',  
            'id_donation_application'     
        )->withPivot('quantity');
    }
}