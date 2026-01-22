<?php
namespace App\Http\Controllers\Api\Volunteers;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\VolunteerOpportunityRepositoryInterface;
use App\Http\Requests\Volunteers\VolunteerOpportunityRequest;
use App\Models\VolunteerOpportunity;

class VolunteerOpportunityController extends Controller {
    protected $opportunityRepo;

    public function __construct(VolunteerOpportunityRepositoryInterface $opportunityRepo) {
        $this->opportunityRepo = $opportunityRepo;
    }

    public function index() {
        return response()->json($this->opportunityRepo->all());
    }

    public function store(VolunteerOpportunityRequest $request) {
        $opportunity = $this->opportunityRepo->create($request->validated());
        return response()->json($opportunity, 201);
    }

    public function show(VolunteerOpportunity $volunteerOpportunity) {
        return response()->json($this->opportunityRepo->findWithCount($volunteerOpportunity->id_volunteer_opportunity));
    }

    public function update(VolunteerOpportunityRequest $request, VolunteerOpportunity $volunteerOpportunity) {
        $opportunity = $this->opportunityRepo->update($volunteerOpportunity->id_volunteer_opportunity, $request->validated());
        return response()->json($opportunity);
    }

    public function destroy(VolunteerOpportunity $volunteerOpportunity) {
        $this->opportunityRepo->delete($volunteerOpportunity->id_volunteer_opportunity);
        return response()->json(null, 204);
    }
}