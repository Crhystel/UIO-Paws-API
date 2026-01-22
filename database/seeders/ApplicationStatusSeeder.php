<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationStatus;

class ApplicationStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Pendiente', 'En Revisión', 'Aprobada', 'Rechazada'];

        foreach ($statuses as $status) {
            ApplicationStatus::firstOrCreate(['status_name' => $status]);
        }
    }
}