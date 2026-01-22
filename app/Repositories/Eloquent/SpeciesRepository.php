<?php

namespace App\Repositories\Eloquent;

use App\Models\Species;
use App\Repositories\Contracts\SpeciesRepositoryInterface;

class SpeciesRepository implements SpeciesRepositoryInterface
{
    public function all()
    {
        return Species::orderBy('species_name')->get();
    }

    public function find($id)
    {
        return Species::findOrFail($id);
    }

    public function create(array $data)
    {
        return Species::create($data);
    }

    public function update($id, array $data)
    {
        $species = Species::findOrFail($id);
        $species->update($data);
        return $species;
    }

    public function delete($id)
    {
        return Species::destroy($id);
    }
}