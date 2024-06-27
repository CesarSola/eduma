<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantePagoCurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'curso_id',
        'comprobante_pago',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
