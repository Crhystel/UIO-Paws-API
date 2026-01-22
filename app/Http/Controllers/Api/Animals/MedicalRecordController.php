<?php
namespace App\Http\Controllers\Api\Animals;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\MedicalRecordRepositoryInterface;
use App\Http\Requests\Animals\MedicalRecordRequest;
use App\Models\Animal;
use App\Models\MedicalRecord;

class MedicalRecordController extends Controller
{
    protected $medicalRepo;

    public function __construct(MedicalRecordRepositoryInterface $medicalRepo) {
        $this->medicalRepo = $medicalRepo;
    }

    public function store(MedicalRecordRequest $request, Animal $animal) {
        $record = $this->medicalRepo->createForAnimal($animal->id_animal, $request->validated());
        return response()->json($record, 201);
    }

    public function update(MedicalRecordRequest $request, MedicalRecord $record) {
        $updated = $this->medicalRepo->update($record->id_record, $request->validated());
        return response()->json($updated, 200);
    }

    public function destroy(MedicalRecord $record) {
        $this->medicalRepo->delete($record->id_record);
        return response()->json(null, 204);
    }
}