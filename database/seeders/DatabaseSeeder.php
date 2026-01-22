<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class, 
            ApplicationStatusSeeder::class, 
            TermsAndConditionsSeeder::class,
            UserSeeder::class, 
        ]);
    }
}