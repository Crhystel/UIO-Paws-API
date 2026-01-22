<?php

namespace App\Repositories\Eloquent;

use App\Models\Shelter;
use App\Repositories\Contracts\ShelterRepositoryInterface;
use App\Factories\ShelterFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ShelterRepository implements ShelterRepositoryInterface
{
    public function all() {
        return Shelter::with('address')->get();
    }

    public function find($id) {
        return Shelter::with('address')->findOrFail($id);
    }

    public function create(array $data) {
        // Delegamos la creación compleja a la Factory
        return ShelterFactory::createWithAddress($data);
    }

    public function update($id, array $data) {
        $shelter = Shelter::findOrFail($id);

        return DB::transaction(function () use ($shelter, $data) {
            if (isset($data['address'])) {
                $shelter->address()->update($data['address']);
            }
            
            $shelterData = Arr::except($data, ['address']);
            $shelter->update($shelterData);
            
            return $shelter->load('address');
        });
    }

    public function delete($id) {
        return Shelter::destroy($id);
    }
}