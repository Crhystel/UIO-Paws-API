<?php
namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\AnimalRepositoryInterface;
use App\Http\Requests\Animals\AnimalRequest; 
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    protected $animalRepo;

    public function __construct(AnimalRepositoryInterface $animalRepo) {
        $this->animalRepo = $animalRepo;
    }

    public function index(Request $request) {
        return response()->json($this->animalRepo->search($request->all()));
    }

    public function store(AnimalRequest $request) {
        // El repositorio ahora hace el ->refresh()
        $animal = $this->animalRepo->create($request->validated()); 
        
        // Retornamos 201 (Created) y el objeto completo
        return response()->json($animal, 201);
    }

    public function show(Animal $animal) {
        return response()->json($animal->load(['breed.species','shelter','photos','medicalRecords']));
    }

    public function update(AnimalRequest $request, Animal $animal) {
        $updatedAnimal = $this->animalRepo->update($animal->id_animal, $request->validated());
        return response()->json($updatedAnimal);
    }

    public function destroy(Animal $animal) {
        $this->animalRepo->delete($animal->id_animal);
        return response()->json(null, 204);
    }
}