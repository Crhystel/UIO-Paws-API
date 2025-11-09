<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerApplicationController extends Controller
{
    public function index(){
    return VolunteerApplication::with(['user', 'status'])->latest('application_date')->paginate(20);
    }
    public function show(VolunteerApplication $application) {
    return $application->load(['user', 'status']);
    }
    public function updateStatus(Request $request, VolunteerApplication $application) {
    $validated = $request->validate([
    'id_status' => 'required|exists:application_statuses,id_status',
    ]);
    $application->update([
    'id_status' => $validated['id_status'],
    'reviewed_by_id_admin' => Auth::id(),
    ]);
    return response()->json($application->load(['user', 'status']));
    }

}
