<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionUsuario extends Model
{
    use HasFactory;

    // La tabla asociada al modelo.
    protected $table = 'atencion_usuarios';

    // Los atributos que son asignables en masa.
    protected $fillable = [
        'user_id',
        'estandar_id',
        'año',
        'presencial',
        'celular',
        'correo',
        'otro_medio',
        'lugar',
        'fecha',
        'nombre',
        'apellidos',
        'domicilio',
        'colonia',
        'codigo_postal',
        'delegacion',
        'estado',
        'ciudad',
        'fax',
        'telefono',
        'email',
        'calificacion_atencion',
        'tiempo_atencion',
        'trato_amable',
        'confianza_atencion',
        'comprension_atencion',
    ];

    // Los atributos que deben ser ocultados para los arrays.
    protected $hidden = [
        // No hay atributos ocultos en este caso
    ];

    // Los atributos que deben ser cast a tipos específicos.
    protected $casts = [
        'fecha' => 'date',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class);
    }
}
