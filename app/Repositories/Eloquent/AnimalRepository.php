<?php

namespace App\Repositories\Eloquent;

use App\Models\Animal;
use App\Repositories\Contracts\AnimalRepositoryInterface;

class AnimalRepository implements AnimalRepositoryInterface
{
    public function search(array $filters)
    {
        $query = Animal::with(['breed.species', 'shelter', 'photos']);
        
        if (!empty($filters['animal_name'])) {
            $query->where('animal_name', 'like', '%' . $filters['animal_name'] . '%');
        }
        if (!empty($filters['id_breed'])) {
            $query->where('id_breed', $filters['id_breed']);
        }

        return $query->paginate(15);
    }

    public function find($id)
    {
        return Animal::with(['breed.species', 'shelter', 'photos', 'medicalRecords'])->findOrFail($id);
    }

    public function create(array $data) 
    { 
        $animal = Animal::create($data);
        $animal->refresh(); 
        
        return $animal;
    }

    public function update($id, array $data)
    {
        $animal = Animal::findOrFail($id);
        $animal->update($data);
        return $animal;
    }

    public function delete($id) { return Animal::destroy($id); }
}