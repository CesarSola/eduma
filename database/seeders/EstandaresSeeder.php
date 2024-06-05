<?php

namespace Database\Seeders;

use App\Models\Estandar; // Ensure you have the Estandar model
use App\Models\Estandares;
use Illuminate\Database\Seeder;

class EstandaresSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Estandares::create([
            'numero' => '001',
            'name' => 'Estandar 1',
            'Dnecesarios' => 'Documento A, Documento B',
            'tipo' => 'Tipo 1',
        ]);

        Estandares::create([
            'numero' => '002',
            'name' => 'Estandar 2',
            'Dnecesarios' => 'Documento C, Documento D',
            'tipo' => 'Tipo 2',
        ]);

        // Add more records as needed
    }
}
