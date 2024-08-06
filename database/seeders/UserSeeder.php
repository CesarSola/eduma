<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Evaluadores;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verifica que los roles existan antes de asignar
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $evaluadorRole = Role::firstOrCreate(['name' => 'Evaluador']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        Administrador::create([
            'name' => 'Juan',
            'secondName' => 'Gabriel',
            'paternalSurname' => 'Contreras',
            'maternalSurname' => 'Sansores',
            'email' => 'admin@material.com',
            'rol' => 'Admin',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
        ])->assignRole($adminRole);

        Evaluadores::create([
            'name' => 'Fabiola',
            'secondName' => 'Anel',
            'paternalSurname' => 'Cuevas',
            'maternalSurname' => 'López',
            'rol' => 'Evaluador',
            'email' => 'evaluador@material.com',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
        ])->assignRole($evaluadorRole);

        User::create([
            'name' => 'Miguel',
            'secondName' => 'Aleman',
            'paternalSurname' => 'Rodriguez',
            'maternalSurname' => 'Medina',
            'email' => 'test@material.com',
            'matricula' => '0001',
            'password' => Hash::make('12345'),
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
<<<<<<< HEAD
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
=======
        ])->assignRole($userRole);
>>>>>>> 340e9db59ab17f1155769fbccd747dc778a71be3
    }
}
