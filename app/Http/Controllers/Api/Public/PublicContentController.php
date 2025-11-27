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
        $query = Animal::with(['breed.species', 'shelter', 'photos']);
        $query->where('status', 'Disponible'); 
        // Nombre
        if ($request->filled('animal_name')) {
            $query->where('animal_name', 'like', '%' . $request->animal_name . '%');
        }

        // Especie (Protegido con is_numeric para evitar errores)
        if ($request->filled('id_species') && is_numeric($request->id_species)) {
            $query->whereHas('breed', function ($q) use ($request) {
                $q->where('id_species', $request->id_species);
            });
        }

        // Raza
        if ($request->filled('id_breed') && is_numeric($request->id_breed)) {
            $query->where('id_breed', $request->id_breed);
        }

        // Refugio
        if ($request->filled('id_shelter') && is_numeric($request->id_shelter)) {
            $query->where('id_shelter', $request->id_shelter);
        }

        // Tamaño
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // Color
        if ($request->filled('color')) {
            $query->where('color', 'like', '%' . $request->color . '%');
        }
        $query->orderBy('id_animal', 'desc');
        // 3. Retornamos la paginación estándar (JSON puro)
        return $query->paginate(12);
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