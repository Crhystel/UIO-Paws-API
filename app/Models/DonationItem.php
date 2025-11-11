<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    use HasFactory;

    protected $table = 'donation_item';
    protected $primaryKey = 'id_donation_item';
    public $timestamps = true;

    protected $fillable = ['id_donation', 'id_donation_item_catalog', 'quantity'];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'id_donation');
    }

    public function catalogItem()
    {
        return $this->belongsTo(DonationItemsCatalog::class, 'id_donation_item_catalog');
    }
}