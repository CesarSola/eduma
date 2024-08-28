<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteCertificacion extends Model
{
    use HasFactory;
    protected $table = 'comprobante_certificacion';
    protected $fillable = [
        'user_id',
        'estandar_id',
        'comprobante_pago',
        'estado',
        'evaluador_id'
    ];
    //relacion del comprobante con el usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //relación del comprobante con el estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id', 'id');
    }

    // Relación con ValidacionesComprobantesCompetencias para validar o rechazar
    public function validaciones()
    {
        return $this->hasMany(ValidacionesCertificaciones::class, 'comprobante_id');
    }

    // Relación con EvaluacionesUsuarios (o EvaluadoresUsuarios)
    public function evaluaciones()
    {
        return $this->hasMany(EvaluadoresUsuarios::class, 'comprobante_id');
    }
    // Relación con User (Evaluador)cuando se asigna un evaluador
    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }
}
