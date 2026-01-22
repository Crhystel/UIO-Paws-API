<?php

namespace App\Repositories\Contracts;

interface MedicalRecordRepositoryInterface
{
    public function find($id);
    public function createForAnimal($animalId, array $data);
    public function update($id, array $data);
    public function delete($id);
}