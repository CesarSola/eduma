<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Administrador extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles; // Usa el trait

    protected $table = 'administradores';
    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'secondName',
        'paternalSurname',
        'maternalSurname',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Método necesario para que Laravel pueda obtener la contraseña del evaluador
    public function getAuthPassword()
    {
        return $this->password;
    }
}
