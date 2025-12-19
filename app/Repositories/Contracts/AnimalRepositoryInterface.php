<?php

namespace App\Repositories\Contracts;

//Repository (Interfaz)
// Define las operaciones permitidas para los animales.
interface AnimalRepositoryInterface
{
    public function search(array $filters);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}