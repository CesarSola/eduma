<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estandares extends Model
{
    use HasFactory;

    protected $table = 'estandares';

    protected $fillable = [
        'numero',
        'name',
        'tipo',
        'calificacion_minima',
        'documentos' // Agrega este campo
    ];
    //sirve para guardar el array de documentos necesarios
    protected $casts = [
        'documentos' => 'array', // Asegura que el campo sea tratado como un array
    ];
    //relación de documentos necesarios a la hora de crear los estandares
    public function documentosnec()
    {
        return $this->belongsToMany(DocumentosNec::class, 'competencia_documentosnec', 'competencia_id', 'documentosnec_id');
    }

    //relacion comprobantes pago competencias
    public function comprobantesCO()
    {
        return $this->hasMany(ComprobantesCO::class, 'estandar_id', 'id');
    }

    //relación de estandares con fechas
    public function fechas()
    {
        return $this->hasMany(FechaCompetencia::class, 'competencia_id');
    }

    //relación de usuarios con estandares
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_estandares', 'estandar_id', 'user_id');
    }
    //relacion con planes de evaluacion
    public function planesEvaluacion()
    {
        return $this->hasMany(PlanesEvaluacion::class);
    }
    // En el modelo Estandares

    public function evaluaciones()
    {
        return $this->hasMany(EvaluadoresUsuarios::class, 'estandar_id');
    }

    // relacion con calificaciones
    public function calificaciones()
    {
        return $this->hasMany(CalificacionEvaluacion::class, 'estandar_id');
    }

    // Obtener validaciones a través de comprobantes
    public function validacionesComentarios()
    {
        return $this->hasManyThrough(
            ValidacionesComprobantesCompetencias::class,
            ComprobantesCO::class,
            'estandar_id', // Foreign key on ComprobantesCO table
            'comprobante_id', // Foreign key on ValidacionesComprobantesCompetencias table
            'id', // Local key on Estandares table
            'id'  // Local key on ComprobantesCO table
        );
    }
}
