<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\Shelter;

class ShelterController extends Controller
{
    public function index(){
        return Shelter::with('address')->get();
    }
    public function store(Request $request){
        $validated=$request->validate([
            'shelter_name'=>'required|string|max:255',
            'contact_email'=>'required|email|max:255',
            'phone'=>'required|string|max:20',
            'description'=>'nullable|string',
            'id_address'=>'required|exists:addresses.id_address',
        ]);
        $shelter=Shelter::create($validated);
        return response()->json($shelter->load('address'),201);
    }
    public function show(Shelter $shelter){
        return $shelter->load('address');
    }
    public function update(Request $request, Shelter $shelter){
        $validated=$request->validate([
            'shelter_name'=>'sometimes|required|string|max:255',
            'contact_email'=>'sometimes|required|email|max:255',
            'phone'=>'sometimes|required|string|max:20',
            'description'=>'sometimes|nullable|string',
            'id_address'=>'sometimes|required|exists:addresses,id_address',
        ]);
        $shelter->update($validated);
        return response()->json($shelter->load('address'));
    }
    public function destroy(Shelter $shelter){
        $shelter->delete();
        return response()->json(null,204);
    }
}
