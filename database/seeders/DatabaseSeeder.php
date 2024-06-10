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
        $this->call(Rolseeder::class);
        $this->call(UserSeeder::class);
        User::factory()->create([
            'name' => 'Angel',
            'secondName' => 'Antonio',
            'paternalSurname' => 'Canul',
            'maternalSurname' => 'Chin',
            'age' => '20',
            'calle_avenida' => 'C18 entre 15 y 17',
            'numext' => 'S/N',
            'd_codigo' => '97818', // Aquí cambia 'codpos' por 'd_codigo'
            'd_asenta' => 'Kopomá', // También cambia las columnas correspondientes si es necesario
            'd_estado' => 'Yucatán',
            'd_ciudad' => 'Kopomá',
            'D_mnpio' => 'Kopomá',
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
            'd_codigo' => '97800', // Aquí cambia 'codpos' por 'd_codigo'
            'd_asenta' => 'Maxcanú', // También cambia las columnas correspondientes si es necesario
            'd_estado' => 'Yucatán',
            'd_ciudad' => 'Maxcanú',
            'D_mnpio' => 'Maxcanú',
            'email' => 'test2@example.com',
            'password' => '12345678',
        ]);
    }
}
