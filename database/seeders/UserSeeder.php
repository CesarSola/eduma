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
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'matricula' => '0000',
            'password' => Hash::make('secret'), // Asegúrate de cifrar la contraseña
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
        ]);

        $admin->assignRole('Admin');

        $admin = User::create([
            'name' => 'Miguel',
            'secondName' => 'Adrian',
            'paternalSurname' => 'Rodriguez',
            'maternalSurname' => 'Alvarado',
            'genero' => 'Hombre',
            'phone' => '9987327293',
            'matricula' => '0001',
            'email' => 'test@material.com',
            'password' => Hash::make('12345'), // Asegúrate de cifrar la contraseña
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
        ]);

        $admin->assignRole('User');

        $admin = User::create([
            'name' => 'Jose',
            'secondName' => 'Gilberto',
            'paternalSurname' => 'Martin',
            'maternalSurname' => 'Perez',
            'genero' => 'Hombre',
            'phone' => '9956386893',
            'matricula' => '0002',
            'email' => 'test2@material.com',
            'password' => Hash::make('12345'), // Asegúrate de cifrar la contraseña
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada

        ]);

        $admin->assignRole('User');
    }
}
