<?php

namespace App\Repositories\Eloquent;

use App\Models\VolunteerOpportunity;
use App\Repositories\Contracts\VolunteerOpportunityRepositoryInterface;

class VolunteerOpportunityRepository implements VolunteerOpportunityRepositoryInterface {
    public function all() {
        return VolunteerOpportunity::withCount('applications')->orderBy('title')->get();
    }
    public function findWithCount($id) {
        return VolunteerOpportunity::withCount('applications')->findOrFail($id);
    }
    public function create(array $data) {
        return VolunteerOpportunity::create($data);
    }
    public function update($id, array $data) {
        $opportunity = VolunteerOpportunity::findOrFail($id);
        $opportunity->update($data);
        return $opportunity;
    }
    public function delete($id) {
        return VolunteerOpportunity::destroy($id);
    }
}