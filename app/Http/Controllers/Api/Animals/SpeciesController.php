<?php
namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SpeciesRepositoryInterface;
use App\Http\Requests\Animals\SpeciesRequest;
use App\Models\Species;

class SpeciesController extends Controller
{
    protected $speciesRepo;

    public function __construct(SpeciesRepositoryInterface $speciesRepo) {
        $this->speciesRepo = $speciesRepo;
    }

    public function index() {
        return response()->json($this->speciesRepo->all());
    }

    public function store(SpeciesRequest $request) {
        $species = $this->speciesRepo->create($request->validated());
        return response()->json($species, 201);
    }

    public function show(Species $species) {
        return response()->json($species);
    }

    public function update(SpeciesRequest $request, Species $species) {
        $updated = $this->speciesRepo->update($species->id_species, $request->validated());
        return response()->json($updated);
    }

    public function destroy(Species $species) {
        $this->speciesRepo->delete($species->id_species);
        return response()->json(null, 204);
    }
}