<?php

namespace App\Http\Controllers\Api\Volunteers;

use App\Http\Controllers\Controller;
use App\Models\VolunteerOpportunity;
use Illuminate\Http\Request;

class VolunteerOpportunityController extends Controller
{
    public function index()
    {
        return VolunteerOpportunity::orderBy('title')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|unique:volunteer_opportunities|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);
        $opportunity = VolunteerOpportunity::create($validated);
        return response()->json($opportunity, 201);
    }

    public function show(VolunteerOpportunity $volunteerOpportunity)
    {
        return $volunteerOpportunity;
    }

    public function update(Request $request, VolunteerOpportunity $volunteerOpportunity)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255|unique:volunteer_opportunities,title,' . $volunteerOpportunity->id_volunteer_opportunity . ',id_volunteer_opportunity',
            'description' => 'sometimes|required|string',
            'requirements' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|required|boolean',
        ]);
        $volunteerOpportunity->update($validated);
        return response()->json($volunteerOpportunity);
    }

    public function destroy(VolunteerOpportunity $volunteerOpportunity)
    {
        $volunteerOpportunity->delete();
        return response()->json(null, 204);
    }
}