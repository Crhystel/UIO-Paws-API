<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationStatus;

class AdoptionApplicationController extends Controller
{
    public function index(){
        return AdoptionApplication::with(['user','animal','status'])->latest('application_date')->paginate(20);
    }
    public function show(AdoptionApplication $application)
    {
        return $application->load(['user', 'animal.breed.species', 'status', 'homeInformation']);
    }
     public function updateStatus(Request $request, AdoptionApplication $application)
    {
        $validated = $request->validate([
            'id_status' => 'required|exists:application_statuses,id_status',
            'admin_notes' => 'nullable|string',
        ]);
        $newStatus = ApplicationStatus::find($validated['id_status']);
        $application->update([
            'id_status' => $validated['id_status'],
            'admin_notes' => $validated['admin_notes'],
            'approved_by_id_admin' => Auth::id(),
        ]);
        if ($newStatus && $newStatus->status_name === 'Rechazada') {
            if ($application->animal) {
                $application->animal->status = 'Disponible';
                $application->animal->save();
            }
        }
        if ($newStatus && $newStatus->status_name === 'Aprobada') {
            if ($application->animal) {
                $application->animal->status = 'Adoptado';
                $application->animal->save();
            }
        }
        return response()->json($application->load(['user', 'animal', 'status']));
    }
}
    

