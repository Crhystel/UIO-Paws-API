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

    protected $fillable = ['item_name', 'description'];
}