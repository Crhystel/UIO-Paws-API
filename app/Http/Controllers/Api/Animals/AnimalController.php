<?php

namespace App\Http\Controllers\Api\Animals;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class AnimalController extends Controller
{
    public function index(Request $request){
        Log::info('--- INICIO BUSQUEDA API ---');
        Log::info('Filtros recibidos:', $request->all());
        $query = Animal::with(['breed.species','shelter', 'photos']);
        if ($request->filled('animal_name')) {
            $query->where('animal_name', 'like', '%' . $request->animal_name . '%');
        }
        if ($request->filled('id_breed')) {
            $query->where('id_breed', $request->id_breed);
        }
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }
        if ($request->filled('color')) {
            $query->where('color', 'like', '%' . $request->color . '%');
        }
        if ($request->filled('id_shelter')) {
            $query->where('id_shelter', $request->id_shelter);
        }
        Log::info('SQL Generado:', [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings()
    ]);
        $animals = $query->paginate(15);
        return response()->json($animals);
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
        $animal = Animal::create($validatedData);
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
        $animal->update($validatedData);
        return response()->json($animal);
    }
    public function destroy(Animal $animal){
        $animal->delete();
        return response()->json(null, 204);
    }
}