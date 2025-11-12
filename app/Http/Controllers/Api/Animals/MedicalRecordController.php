<?php

namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Guarda un nuevo registro médico para un animal.
     */
    public function store(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'event_date' => 'required|date',
            'event_type' => 'required|string|max:255', 
            'description' => 'required|string',
            'veterinarian_name' => 'nullable|string|max:255',
            'medication' => 'nullable|string|max:255',
        ]);

        $record = $animal->medicalRecords()->create($validated);

        return response()->json($record, 201);
    }
     /**
     * Actualiza un registro médico existente.
     */
    public function update(Request $request, MedicalRecord $record)
    {
        // Usamos 'sometimes' para validar solo los campos que se envían.
        $validated = $request->validate([
            'event_date' => 'sometimes|required|date',
            'event_type' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'veterinarian_name' => 'nullable|string|max:255',
            'medication' => 'nullable|string|max:255',
        ]);

        $record->update($validated);
        return response()->json($record, 200);
    }

    /**
     * Elimina un registro médico.
     */
    public function destroy(MedicalRecord $record)
    {
        $record->delete();
        return response()->json(null, 204);
    }
}