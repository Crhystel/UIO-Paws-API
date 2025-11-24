<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Importante añadir esto
use Carbon\Carbon; // Importante añadir esto

class TermsAndConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms_and_conditions')->insert([
            'full_text' => 'El adoptante se compromete a proporcionar un ambiente seguro y amoroso para el animal. Esto incluye, pero no se limita a, proveer alimento adecuado, agua fresca, refugio contra las inclemencias del tiempo, atención veterinaria regular y de emergencia. El adoptante acepta no someter al animal a maltrato, abandono o cualquier forma de crueldad. La organización se reserva el derecho de realizar seguimientos periódicos para asegurar el bienestar del animal adoptado.',
            'version' => '1.0.0',
            'publication_date' => Carbon::now(),
        ]);
    }
}