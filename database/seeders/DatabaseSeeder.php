<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Angel',
            'secondName' => 'Antonio',
            'paternalSurname' => 'Canul',
            'maternalSurname' => 'Chin',
            'calle_avenida' => 'C18 entre 15 y 17',
            'numext' => 'S/N',
            'codpos' => '97818',
            'colonia' => 'Kopomá',
            'estado' => 'Yucatán',
            'ciudad' => 'Kopomá',
            'municipio' => 'Kopomá',
            'email' => 'test@example.com',
            'password' => '12345678',

        ]);
    }
}
