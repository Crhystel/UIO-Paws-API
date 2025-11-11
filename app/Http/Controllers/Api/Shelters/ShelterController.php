<?php

namespace App\Http\Controllers\Api\Shelters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shelter;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class ShelterController extends Controller
{
    public function index(){
        return Shelter::with('address')->get();
    }
    public function store(Request $request){
        $validated=$request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:shelters,contact_email',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);
        $shelter = DB::transaction(function () use ($validated) {
            $address = Address::create($validated['address']);
            $shelterData = $validated;
            $shelterData['id_address'] = $address->id_address;
            return Shelter::create($shelterData);
        });
        return response()->json($shelter->load('address'),201);
    }
    public function show(Shelter $shelter){
        return $shelter->load('address');
    }
    public function update(Request $request, Shelter $shelter){
        $validated=$request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:shelters,contact_email',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);
        DB::transaction(function () use ($validated, $shelter) {
            if (isset($validated['address'])) {
                $shelter->address()->updateOrCreate([], $validated['address']);
            }
            $shelter->update($validated);
        });

        return response()->json($shelter->load('address'));
    }
    public function destroy(Shelter $shelter){
        $shelter->delete();
        return response()->json(null,204);
    }
}
