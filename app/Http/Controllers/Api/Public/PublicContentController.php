<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\DonationItemsCatalog;
use Illuminate\Http\Request;
use App\Models\VolunteerOpportunity;

class PublicContentController extends Controller
{
    /**
     * Muestra una lista de animales con filtros.
     */
    public function listAnimals(Request $request)
    {
        $query = Animal::query()->where('status', 'Disponible'); 

        // Filtrar por especie
        $query->when($request->species_id, function ($q, $species_id) {
            return $q->whereHas('breed', function ($q2) use ($species_id) {
                $q2->where('id_species', $species_id);
            });
        });

        // Filtrar por raza
        $query->when($request->breed_id, function ($q, $breed_id) {
            return $q->where('id_breed', $breed_id);
        });

        // Filtrar por tamaño
        $query->when($request->size, function ($q, $size) {
            return $q->where('size', $size);
        });

        // Filtrar por sexo
        $query->when($request->sex, function ($q, $sex) {
            return $q->where('sex', $sex);
        });

        return $query->with(['breed.species', 'shelter', 'photos'])->paginate(12);
    }

    /**
     * Muestra la información detallada de un solo animal.
     */
    public function showAnimal(Animal $animal)
    {
        return $animal->load(['breed.species', 'shelter', 'photos', 'medicalRecords']);
    }

    /**
     * Muestra la lista de artículos que se necesitan para donar.
     */
    public function listDonationItems()
    {
        return DonationItemsCatalog::orderBy('item_name')->get();
    }
    public function listVolunteerOpportunities()
    {
        return VolunteerOpportunity::where('is_active', true)->orderBy('title')->get();
    }
}