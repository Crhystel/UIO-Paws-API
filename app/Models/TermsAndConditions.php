<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsAndConditions extends Model
{
    use HasFactory;

    protected $table = 'terms_and_conditions';
    protected $primaryKey = 'id_terms_conditions';
    public $timestamps = false;

    protected $fillable = ['full_text', 'version', 'publication_date'];
}