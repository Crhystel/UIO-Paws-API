<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $table = 'application_statuses';
    protected $primaryKey = 'id_status';
    public $timestamps = true;

    protected $fillable = ['status_name'];
}