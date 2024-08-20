<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluadoresUsuarios extends Model
{
    use HasFactory;

    protected $table = 'evaluadores_usuarios';

    protected $fillable = [
        'usuario_id',
        'estandar_id',
        'evaluador_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id');
    }

    public function evaluador()
    {
        return $this->belongsTo(User::class, 'evaluador_id');
    }
    // Relación con ComprobantesCO
    public function comprobante()
    {
        return $this->belongsTo(ComprobantesCO::class, 'comprobante_id');
    }
}
