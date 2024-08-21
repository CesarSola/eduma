<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el usuario Admin y asignarle el rol de 'Admin'
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'matricula' => '0000',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
            'rol' => 'Admin', // Guardar el rol en la columna 'rol'
        ]);
        $admin->assignRole('Admin');

        // Crear el usuario Miguel y asignarle el rol de 'User'
        $user1 = User::create([
            'name' => 'Miguel',
            'secondName' => 'Adrian',
            'paternalSurname' => 'Rodriguez',
            'maternalSurname' => 'Alvarado',
            'genero' => 'Hombre',
            'phone' => '9987327293',
            'matricula' => '0001',
            'email' => 'test@material.com',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
            'rol' => 'User', // Guardar el rol en la columna 'rol'
        ]);
        $user1->assignRole('User');

        // Crear el usuario Jose y asignarle el rol de 'User'
        $user2 = User::create([
            'name' => 'Jose',
            'secondName' => 'Gilberto',
            'paternalSurname' => 'Martin',
            'maternalSurname' => 'Perez',
            'genero' => 'Hombre',
            'phone' => '9956386893',
            'matricula' => '0002',
            'email' => 'test2@material.com',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(),
            'rol' => 'User', // Guardar el rol en la columna 'rol'
        ]);
        $user2->assignRole('User');
    }
}
