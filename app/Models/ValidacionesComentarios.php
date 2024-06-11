<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesComentarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'documento_user_id',
        'comprobante_pago_id',
        'tipo_documento',
        'tipo_validacion',
        'comentario',
    ];
}
