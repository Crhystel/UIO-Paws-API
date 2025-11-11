<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTermAcceptance extends Model
{
    use HasFactory;

    protected $table = 'user_term_acceptance';
    protected $primaryKey = 'id_user_acceptance';
    public $timestamps = true;
    protected $fillable = ['id_user', 'id_terms_conditions', 'acceptance_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function terms()
    {
        return $this->belongsTo(TermsAndConditions::class, 'id_terms_conditions');
    }
}