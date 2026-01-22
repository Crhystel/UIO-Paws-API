<?php

namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\BreedRepositoryInterface;
use App\Http\Requests\Animals\BreedRequest;
use App\Models\Breed;

class BreedController extends Controller
{
    protected $breedRepo;

    public function __construct(BreedRepositoryInterface $breedRepo) {
        $this->breedRepo = $breedRepo;
    }

    public function index() {
        return response()->json($this->breedRepo->all());
    }

    public function store(BreedRequest $request) {
        // Usamos el Request validado y el Repo
        $breed = $this->breedRepo->create($request->validated());
        return response()->json($breed->load('species'), 201);
    }

    public function show(Breed $breed) {
        return response()->json($breed->load('species'));
    }

    public function update(BreedRequest $request, Breed $breed) {
        $updated = $this->breedRepo->update($breed->id_breed, $request->validated());
        return response()->json($updated->load('species'));
    }

    public function destroy(Breed $breed) {
        $this->breedRepo->delete($breed->id_breed);
        return response()->json(null, 204);
    }
}