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
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => Hash::make('secret'), // Asegúrate de cifrar la contraseña
            'email_verified_at' => now(), // Establece la fecha y hora actual como verificada
        ]);

        $user->assignRole('Admin');
    }
}
