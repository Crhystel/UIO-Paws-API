<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdoptionApplicationController extends Controller
{
    public function index(){
        return AdoptionApplication::with(['user','animal','status'])->latest('application_date')->paginate(20);
    }
    public function show(AdoptionApplication $application)
    {
        return $application->load(['user', 'animal', 'status', 'homeInformation']);
    }
    public function updateStatus(Request $request, AdoptionApplication $application)
    {
        $validated = $request->validate([
        'id_status' => 'required|exists:application_statuses,id_status',
        'admin_notes' => 'nullable|string',
        ]);

        $application->update([
        'id_status' => $validated['id_status'],
        'admin_notes' => $validated['admin_notes'],
        'approved_by_id_admin' => Auth::id(),
        ]);
        return response()->json($application->load(['user', 'animal', 'status']));
    }
}
    

