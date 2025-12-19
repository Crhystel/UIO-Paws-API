<?php

namespace App\Repositories\Contracts;

//Repository (Interfaz)
//Separada de animales para cumplir con Interface Segregation (ISP).
interface ShelterRepositoryInterface
{
    public function all();
    public function find($id);
}