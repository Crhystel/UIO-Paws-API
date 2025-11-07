<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\ApplicationStatus;

class ApplicationStatusController extends Controller
{
    public function index(){
        return ApplicationStatus::all();
    }
    public function store(Request $request){
        $validated=$request->validate([
            'status_name'=>'required|string|unique:application_statuses|max:255'
        ]);
        $status=ApplicationStatus::create($validated);
        return response()->json($status,201);
    }
    public function show(ApplicationStatus $applicationStatus){
        return $applicationStatus;
    }
    public function update(Request $request, ApplicationStatus $applicationStatus){
        $validated=$request->validate([
            'status_name'=>'required|string|unique:application_statuses,status_name,'.$applicationStatus->id_status.',id_status|max:255'
        ]);
        $applicationStatus->update($validated);
        return response()->json($applicationStatus);
    }
    public function destroy(ApplicationStatus $applicationStatus){
        $applicationStatus->delete();
        return response()->json($applicationStatus,204);
    }
}
