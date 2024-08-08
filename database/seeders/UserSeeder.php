<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('Admin');

        // Crear usuario User
        $user = User::create([
            'name' => 'Angel',
            'secondName' => 'Antonio',
            'paternalSurname' => 'Canul',
            'maternalSurname' => 'Chin',
            'age' => '20',
            'calle_avenida' => 'C18 entre 15 y 17',
            'numext' => 'S/N',
            'd_codigo' => '97818',
            'd_asenta' => 'Kopomá',
            'd_estado' => 'Yucatán',
            'd_ciudad' => 'Kopomá',
            'D_mnpio' => 'Kopomá',
            'email' => 'test@example.com',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
        ]);

        $user->assignRole('User');

        // Crear usuario Evaluador
        $evaluator = User::create([
            'name' => 'José',
            'secondName' => 'Luis',
            'paternalSurname' => 'Pérez',
            'maternalSurname' => 'Moo',
            'age' => '45',
            'calle_avenida' => 'C32 entre 28 y 27',
            'numext' => 'S/N',
            'd_codigo' => '97800',
            'd_asenta' => 'Maxcanú',
            'd_estado' => 'Yucatán',
            'd_ciudad' => 'Maxcanú',
            'D_mnpio' => 'Maxcanú',
            'email' => 'test2@example.com',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
        ]);

        $evaluator->assignRole('Evaluador');
    }
}
