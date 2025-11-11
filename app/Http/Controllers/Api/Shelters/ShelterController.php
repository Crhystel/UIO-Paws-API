<?php

namespace App\Http\Controllers\Api\Shelters;

<<<<<<< HEAD
use App\Http\Controllers\Controller;
use App\Models\Shelter;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr; 
=======
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Shelter;
>>>>>>> c4804f8 (rearranging controller files)

class ShelterController extends Controller
{
    public function index(){
        return Shelter::with('address')->get();
    }
<<<<<<< HEAD

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

        $shelter = DB::transaction(function () use ($validated) {
            // 1. Crear la dirección
            $address = Address::create($validated['address']);
            $shelterData = Arr::except($validated, ['address']);
            $shelterData['id_address'] = $address->id_address;
            return Shelter::create($shelterData);
        });

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
=======
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
>>>>>>> c4804f8 (rearranging controller files)
