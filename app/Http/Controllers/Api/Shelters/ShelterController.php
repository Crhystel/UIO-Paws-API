<?php

namespace App\Http\Controllers\Api\Shelters;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ShelterRepositoryInterface;
use App\Http\Requests\Shelters\ShelterRequest;
use App\Models\Shelter;

class ShelterController extends Controller
{
    protected $shelterRepo;

    public function __construct(ShelterRepositoryInterface $shelterRepo) {
        $this->shelterRepo = $shelterRepo;
    }

    public function index() {
        return response()->json($this->shelterRepo->all());
    }

    public function store(ShelterRequest $request) {
        $shelter = $this->shelterRepo->create($request->validated());
        return response()->json($shelter->load('address'), 201); 
    }

    public function show(Shelter $shelter) {
        return response()->json($shelter->load('address'));
    }

    public function update(ShelterRequest $request, Shelter $shelter) {
        $updated = $this->shelterRepo->update($shelter->id_shelter, $request->validated());
        return response()->json($updated); 
    }

    public function destroy(Shelter $shelter) {
        $this->shelterRepo->delete($shelter->id_shelter);
        return response()->json(null, 204);
    }
}