<?php

namespace App\Http\Controllers\Api\Animals;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\Species;

class SpeciesController extends Controller
{
    public function index(){
        return Species::orderBy('species_name')->get();
    }
    public function store(Request $request){
        $validated=$request->validate([
            'species_name'=>'required|string|unique:species|max:255'
        ]);
        $species=Species::create($validated);
        return response()->json($species,201);
    }
    public function show(Species $species){
        return $species;
    }
    public function update(Request $request, Species $species){
        $validated=$request->validate([
            'species_name'=>'required|string|unique:species,species_name,'.$species->id_species.',id_species|max:255'
        ]);
        $species->update($validated);
        return response()->json($species);
    }
    public function destroy(Species $species){
        $species->delete();
        return response()->json(null, 204); 
    }
}
