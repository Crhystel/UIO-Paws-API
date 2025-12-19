<?php

namespace App\Factories;

use App\Models\Shelter;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

// Factory
// Encargado de construir objetos complejos que involucran múltiples tablas.
class ShelterFactory
{
    public static function createWithAddress(array $data): Shelter
    {
        return DB::transaction(function () use ($data) {
            // 1. Crear la dirección primero
            $address = Address::create($data['address']);
            
            // 2. Crear el refugio asociado
            $shelterData = Arr::except($data, ['address']);
            $shelterData['id_address'] = $address->id_address;
            
            return Shelter::create($shelterData);
        });
    }
}