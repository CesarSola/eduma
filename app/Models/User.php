<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles; // Importa el trait

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles; // Usa el trait

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
        'genero',
        'matricula',
        'curp',
        'nacionalidad',
        'nacimiento',
        'foto',
        'phone',
        'active',
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

    //relacón donde el comprobante de cursos toma el id de usuario
    public function comprobantesCU()
    {
        return $this->hasMany(comprobantesCU::class);
    }
    //relacón donde el comprobante de competencias toma el id de usuario
    public function comprobantesCO()
    {
        return $this->hasMany(comprobantesCO::class);
    }

    // Relación muchos a muchos con el modelo Estandares
    public function estandares()
    {
        return $this->belongsToMany(Estandares::class, 'user_estandares', 'user_id', 'estandar_id');
    }

    // Relación muchos a muchos con el modelo Curso
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'user_curso', 'user_id', 'curso_id');
    }
    // relacion donde validaciones comprobantes competencias toma el id del usuario
    public function evidencias()
    {
        return $this->belongsToMany(ValidacionesComprobantesCompetencias::class);
    }
    // relacion donde guardar cartas
    public function cartas()
    {
        return $this->hasMany(CartasDocumentos::class);
    }
    // relacion donde guardar fichas
    public function fichas()
    {
        return $this->hasMany(FichasDocumentos::class);
    }
    // Relación con DocumentosEvidencias
    public function documentosE()
    {
        return $this->hasMany(DocumentosEvidencias::class, 'user_id');
    }
    // Métodos para desactivar y reactivar cuentas de usuario
    public function deactivateAccount(User $user)
    {
        $user->active = 0;
        $user->save();

        // Redirigir o mostrar un mensaje de éxito
    }

    public function reactivateAccount(User $user)
    {
        $user->active = 1;
        $user->save();

        // Redirigir o mostrar un mensaje de éxito
    }

    // Método para generar la matrícula automáticamente solo para usuarios con rol 'User'
    // Dentro del modelo User
    public static function boot()
    {
        parent::boot();

        // Evento de creación del usuario
        static::creating(function ($user) {
            // Verificar si el usuario tiene el rol 'User'
            if ($user->hasRole('User')) {
                // Generar la matrícula solo si aún no está definida
                if (!$user->matricula) {
                    $user->matricula = static::generateMatricula();
                }
            }
        });
    }

    public static function generateMatricula()
    {
        // Obtener el ID del rol "User"
        $roleId = Role::where('name', 'User')->first()->id;

        // Obtener el último número de matrícula para el rol específico
        $latestUser = static::whereHas('roles', function ($query) use ($roleId) {
            $query->where('role_id', $roleId);
        })
            ->orderBy('created_at', 'desc')
            ->first();

        // Si no hay usuarios con ese rol, empezamos con '0001'
        if (!$latestUser) {
            return '0001';
        }

        // Obtener el último número de matrícula y generar el siguiente número
        $lastNumber = (int) substr($latestUser->matricula, -4);
        $newNumber = $lastNumber + 1;

        // Generar la nueva matrícula y asegurar que tenga 4 dígitos
        $newMatricula = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Verificar si la matrícula ya existe y generar una nueva si es necesario
        while (static::where('matricula', $newMatricula)->exists()) {
            $newNumber++;
            $newMatricula = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }

        return $newMatricula;
    }


    // relaciones para agregar las relaciones de comprobantesCO y validaciones comprobantes competencias en la tabla pivot user_estandares
    public function attachEstandarIfNotAttached1($estandarId)
    {
        if (!$this->estandares()->where('estandar_id', $estandarId)->exists()) {
            $this->estandares()->attach($estandarId);
        }
    }
    // relaciones para agregar las relaciones de comprobantesCU y validaciones comprobantes cursos en la tabla pivot user_curso
    public function attachEstandarIfNotAttached2($cursoId)
    {
        if (!$this->cursos()->where('curso_id', $cursoId)->exists()) {
            $this->cursos()->attach($cursoId);
        }
    }
}
