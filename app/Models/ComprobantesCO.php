<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantesCO extends Model
{
    use HasFactory;
    protected $table = 'comprobantes_competencias';
    protected $fillable = [
        'user_id',
        'estandar_id',
        'comprobante_pago',
        'tipo_validacion',
    ];
    //relacion del comprobante con el usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //relación del comprobante con el estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandares_id', 'id');
    }

    // Relación con ValidacionesComprobantesCompetencias
    public function validaciones()
    {
        return $this->hasMany(ValidacionesComprobantesCompetencias::class, 'comprobante_id');
    }
}
