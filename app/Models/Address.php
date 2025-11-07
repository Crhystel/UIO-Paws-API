<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illutiminate\Database\Eloquent\Model;

class Address extends Model{
    use HasFactory;
    protected $table='addresses';
    protected $primaryKey='id_address';
    public $timestamps = false;
    protected $fillable=[
        'street',
        'city',
        'province',
        'postal_code',
        'country'
    ];
}