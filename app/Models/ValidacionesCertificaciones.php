<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesCertificaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'comprobante_id',
        'user_id',
        'tipo_documento',
        'tipo_validacion',
        'comentario',
    ];

    //relación que une comprobantes_competencias con comprobantes competencias
    public function comprobanteCE()
    {
        return $this->belongsTo(ComprobanteCertificacion::class, 'comprobante_id');
    }
    // Relación que une validaciones_comprobantes_competencias con usuarios
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
