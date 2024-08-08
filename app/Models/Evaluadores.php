<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Evaluadores extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Usa el trait

    protected $table = 'evaluadores';

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
