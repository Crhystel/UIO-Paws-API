<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\DonationApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Devuelve un resumen de todas las solicitudes pendientes para el panel de admin.
     */
    public function getApplicationSummary()
    {
        $adoptions = AdoptionApplication::with(['user:id_user,first_name,last_name', 'status'])
            ->latest('application_date')
            ->paginate(20, ['*'], 'adoptions_page'); 
        $donations = DonationApplication::with(['user:id_user,first_name,last_name', 'status'])
            ->latest('application_date')
            ->paginate(20, ['*'], 'donations_page');

        return response()->json([
            'adoptions' => $adoptions,
            'donations' => $donations,
        ]);
    }
}