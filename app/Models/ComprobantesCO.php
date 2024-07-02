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
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandares_id', 'id');
    }
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
    public function validacionesComentarios()
    {
        return $this->hasMany(ValidacionesComentarios::class, 'comprobante_pago_id');
    }
}
