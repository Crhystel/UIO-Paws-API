<?php

namespace App\Http\Controllers\Api\Shelters;

use App\Http\Controllers\Controller;
use App\Models\Shelter;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr; 
use App\Factories\ShelterFactory; //Factory

class ShelterController extends Controller
{
    public function index(){
        return Shelter::with('address')->get();
    }

    public function store(Request $request){
        $validated = $request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:shelters,contact_email',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);

        // PATRÓN: Factory
        //  Delegamos la creación compleja (Shelter + Address) a la Factory.
        $shelter = ShelterFactory::createWithAddress($validated);

        return response()->json($shelter->load('address'), 201); 
    }

    public function show(Shelter $shelter){
        return $shelter->load('address');
    }

    public function update(Request $request, Shelter $shelter){
        $validated = $request->validate([
            'shelter_name' => 'required|string|max:255',
            'contact_email' => 'required|email|unique:shelters,contact_email,' . $shelter->id_shelter . ',id_shelter',
            'phone' => 'required|string|max:20',
            'description' => 'nullable|string',
            'address' => 'required|array',
            'address.street' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.province' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'address.country' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated, $shelter) {
            if (isset($validated['address'])) {
                $shelter->address()->update($validated['address']);
            }
            $shelterData = Arr::except($validated, ['address']);
            $shelter->update($shelterData);
        });

        return response()->json($shelter->load('address')); 
    }

    public function destroy(Shelter $shelter){
        $shelter->delete();
        return response()->json(null, 204);
    }
}