<?php

namespace App\Repositories\Eloquent;

use App\Models\MedicalRecord;
use App\Models\Animal;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;

class MedicalRecordRepository implements MedicalRecordRepositoryInterface
{
    public function find($id)
    {
        return MedicalRecord::findOrFail($id);
    }

    public function createForAnimal($animalId, array $data)
    {
        $animal = Animal::findOrFail($animalId);
        return $animal->medicalRecords()->create($data);
    }

    public function update($id, array $data)
    {
        $record = MedicalRecord::findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        return MedicalRecord::destroy($id);
    }
}