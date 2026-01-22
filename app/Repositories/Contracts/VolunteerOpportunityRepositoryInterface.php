<?php

namespace App\Repositories\Contracts;

interface VolunteerOpportunityRepositoryInterface {
    public function all();
    public function findWithCount($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}