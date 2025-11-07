<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\Breed;

class BreedController extends Controller
{
    public function index(){
        return Breed::with('species')->orderBy('breed_name')->get();
    }
    public function store(Request $request){
        $validated=$request->validate([
            'breed_name'=>'required|string|max:255',
            'id_species'=>'required|exists:species,id_species',
        ]);
        $breed=Breed::create($validated);
        return response()->json($breed->load('species'),201);
    }
    public function show(Breed $breed){
        return $breed->load('species');
    }
    public function update(Request $request,Breed $breed){
        $validated=$request->validae([
            'breed_name'=>'sometimes|required|string|max:255',
            'id_species'=>'sometimes|required|exists:species,id_species'
        ]);
        $breed->update($validated);
        return response()->json($breed->load('species'));
    }
    public function destroy(Breed $breed){
        $breed->delete();
        return response()->json(null,204);
    }
}
