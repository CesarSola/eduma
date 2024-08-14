<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesComprobantesCompetencias extends Model
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
    public function comprobante()
    {
        return $this->belongsTo(ComprobantesCO::class, 'comprobante_id');
    }
    // Relación que une validaciones_comprobantes_competencias con usuarios
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
