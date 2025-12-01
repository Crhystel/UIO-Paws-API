<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Models\VolunteerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteerApplicationController extends Controller
{
    public function index(Request $request){
        $query = VolunteerApplication::with(['user', 'status', 'opportunity']);
        
        if ($request->filled('status')) {
            $query->whereHas('status', function($q) use ($request) {
                $q->where('id_status', $request->status);
            });
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest('application_date')->paginate(20);
    }
    public function show(VolunteerApplication $application) {
        return $application->load(['user', 'status', 'opportunity']);
    }
    public function updateStatus(Request $request, VolunteerApplication $application) {
        $validated = $request->validate([
            'id_status' => 'required|exists:application_statuses,id_status',
            'admin_notes' => 'nullable|string' 
        ]);
        $application->update([
            'id_status' => $validated['id_status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
            'reviewed_by_id_admin' => Auth::id(), 
        ]);

        return response()->json($application->load(['user', 'status', 'opportunity']));
    }

}
