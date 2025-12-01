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
    public function storeVolunteer(Request $request)
    {
        $validated = $request->validate([
            'motivation' => 'required|string|min:50|max:2000',
            'id_volunteer_opportunity' => 'nullable|exists:volunteer_opportunities,id_volunteer_opportunity',
        ]);
        
        $pendingStatus = \App\Models\ApplicationStatus::where('status_name', 'Pendiente')->first();
        if (!$pendingStatus) {
            return response()->json(['message' => 'Error de configuración.'], 500);
        }

        \App\Models\VolunteerApplication::create([
            'id_user' => \Illuminate\Support\Facades\Auth::id(),
            'motivation' => $validated['motivation'], 
            'application_date' => now(),
            'id_status' => $pendingStatus->id_status,
            'id_volunteer_opportunity' => $validated['id_volunteer_opportunity'] ?? null,
        ]);

        return response()->json(['message' => 'Solicitud enviada con éxito.'], 201);
    }
}