<?php

namespace App\Http\Controllers\Api\Applications;

use App\Http\Controllers\Controller;
use App\Models\DonationApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationApplicationController extends Controller
{
    public function index()
    {
        return DonationApplication::with(['user:id_user,first_name,last_name', 'status'])->latest('application_date')->paginate(20);
    }

    public function show(DonationApplication $application)
    {
        return $application->load(['user', 'status', 'items']);
    }

    public function updateStatus(Request $request, DonationApplication $application)
    {
        $validated = $request->validate([
            'id_status' => 'required|exists:application_statuses,id_status',
            'admin_notes' => 'nullable|string',
        ]);

        $application->update([
            'id_status' => $validated['id_status'],
            'admin_notes' => $validated['admin_notes'],
            'reviewed_by_id_admin' => Auth::id(),
        ]);

        return response()->json($application->load(['user', 'status', 'items']));
    }
}
