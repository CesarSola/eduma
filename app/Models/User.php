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
        'd_codigo',
        'd_asenta',
        'd_estado',
        'd_ciudad',
        'D_mnpio',
        'foto',
        'phone'
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

    // Relación de uno a muchos con el modelo DocumentosUser
    public function documentos()
    {
        return $this->hasMany(DocumentosUser::class);
    }

    // Relación de uno a muchos con el modelo ComprobantePago
    public function comprobantes()
    {
        return $this->hasMany(ComprobantePago::class);
    }

    // Relación muchos a muchos con el modelo Estandares
    public function estandares()
    {
        return $this->belongsToMany(Estandares::class, 'user_estandares', 'user_id', 'estandar_id');
    }
    // Relación muchos a muchos con el modelo Curso
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'user_curso');
    }
}
