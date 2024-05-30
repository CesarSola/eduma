<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Reglas de validación
    static $rules = [
        'name' => 'required',
        'secondName' => 'required',
        'paternalSurname' => 'required',
        'maternalSurname' => 'required',
        'age' => 'required|integer',
        'email' => 'required|string|email|max:255|unique:users,email',
        // Agrega más reglas según sea necesario
    ];

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'secondName',
        'paternalSurname',
        'maternalSurname',
        'age',
        'email',
        'password',
        'google_id',
        'calle_avenida',
        'numext',
        'codpos',
        'colonia',
        'estado',
        'ciudad',
        'municipio',
    ];

    // Campos que deben estar ocultos para la serialización
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Atributos que deben ser casteados
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
