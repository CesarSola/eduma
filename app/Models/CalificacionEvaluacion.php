<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_evaluaciones';

    protected $fillable = [
        'evaluador_id',
        'user_id',
        'nombre_usuario',
        'matricula',
        'estandar_id',
        'evidencias',
        'evaluacion',
        'presentacion',
    ];

    // Relación con el modelo User (Evaluador)
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }

    // Relación con el modelo User (Usuario)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación con el modelo Estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id');
    }
}
