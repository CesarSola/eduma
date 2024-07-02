<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantesCU extends Model
{
    use HasFactory;
    protected $table = 'comprobantes_cursos';
    protected $fillable = [
        'user_id',
        'curso_id',
        'comprobante_pago',
        'tipo_validacion',
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
