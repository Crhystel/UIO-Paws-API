<?php

namespace App\Repositories\Eloquent;

use App\Models\Breed;
use App\Repositories\Contracts\BreedRepositoryInterface;

class BreedRepository implements BreedRepositoryInterface
{
    public function all()
    {
        return Breed::with('species')->orderBy('breed_name')->get();
    }

    public function find($id)
    {
        return Breed::with('species')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Breed::create($data);
    }

    public function update($id, array $data)
    {
        $breed = Breed::findOrFail($id);
        $breed->update($data);
        return $breed;
    }

    public function delete($id)
    {
        return Breed::destroy($id);
    }
}