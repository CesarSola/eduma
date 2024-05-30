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
            'age' => '20',
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
        User::factory()->create([
            'name' => 'Jose',
            'secondName' => 'Luis',
            'paternalSurname' => 'Perez',
            'maternalSurname' => 'May',
            'age' => '45',
            'calle_avenida' => 'C15 entre 16 y 12',
            'numext' => 'S/N',
            'codpos' => '97800',
            'colonia' => 'Maxcanú',
            'estado' => 'Yucatán',
            'ciudad' => 'Maxcanú',
            'municipio' => 'Maxcanú',
            'email' => 'test2@example.com',
            'password' => '12345678',

        ]);
    }
}
