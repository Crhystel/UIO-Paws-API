<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TermsAndConditionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('terms_and_conditions')->updateOrInsert(
            ['version' => '1.0.0'], // Condición para buscar
            [
                'full_text' => 'El adoptante se compromete a proporcionar un ambiente seguro y amoroso para el animal. Esto incluye, pero no se limita a, proveer alimento adecuado, agua fresca, refugio contra las inclemencias del tiempo, atención veterinaria regular y de emergencia. El adoptante acepta no someter al animal a maltrato, abandono o cualquier forma de crueldad. La organización se reserva el derecho de realizar seguimientos periódicos para asegurar el bienestar del animal adoptado.',
                'publication_date' => Carbon::now(),
            ]
        );
    }
}