<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationStatus;

class ApplicationStatusSeeder extends Seeder
{
    public function run(): void
    {
        ApplicationStatus::create(['status_name' => 'Pendiente']);
        ApplicationStatus::create(['status_name' => 'En Revisión']);
        ApplicationStatus::create(['status_name' => 'Aprobada']);
        ApplicationStatus::create(['status_name' => 'Rechazada']);
    }
}