<?php

namespace App\Http\Controllers\Api\Animals;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\AnimalRepositoryInterface;

class AnimalController extends Controller
{
    protected $animalRepo;
    //Patron Repository
    //Inyeccion de dependencias
    public function __construct(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }
    public function index(Request $request){
        //La logica de filtrado se movió al repositorio
        return response()->json($this->animalRepo->search($request->all()));
    }
    public function store(Request $request){
        $validatedData = $request->validate([
        'animal_name' => 'required|string|max:255',
        'status' => 'required|string',
        'birth_date' => 'nullable|date',
        'color' => 'required|string|max:50',
        'is_sterilized' => 'required|boolean',
        'description' => 'nullable|string',
        'id_breed' => 'required|exists:breeds,id_breed', 
        'id_shelter' => 'required|exists:shelters,id_shelter', 
        'sex' => 'required|in:Macho,Hembra',
        'age' => 'required|integer|min:0',
        'size' => 'required|in:Pequeño,Mediano,Grande',
        ]);
        //Uso de repo no del modelo directamente
        $animal = $this->animalRepo->create($validatedData); 
        return response()->json($animal, 201);
    }
    public function show(Animal $animal){
        $animal->load(['breed.species','shelter','photos','medicalRecords']);
        return response()->json($animal);
    }
    public function update(Request $request, Animal $animal){
        $validatedData = $request->validate([
        'animal_name' => 'sometimes|required|string|max:255',
        'status' => 'sometimes|required|string',
        'birth_date' => 'sometimes|nullable|date',
        'color' => 'sometimes|required|string|max:50',
        'is_sterilized' => 'sometimes|required|boolean', 
        'description' => 'sometimes|nullable|string',
        'id_breed' => 'sometimes|required|exists:breeds,id_breed', 
        'id_shelter' => 'sometimes|required|exists:shelters,id_shelter', 
        'sex' => 'sometimes|required|in:Macho,Hembra',
        'age' => 'sometimes|required|integer|min:0',
        'size' => 'sometimes|required|in:Pequeño,Mediano,Grande',
        ]);
        //Uso de repo no del modelo directamente
        $updatedAnimal = $this->animalRepo->update($animal->id_animal, $validatedData);
        return response()->json($updatedAnimal);
    }
    public function destroy(Animal $animal){
        //Uso de repo no del modelo directamente
        $this->animalRepo->delete($animal->id_animal);
        return response()->json(null, 204);
    }
}