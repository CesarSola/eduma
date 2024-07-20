<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesCartas extends Model
{
    use HasFactory;
    protected $table = 'validaciones_cartas';

    protected $fillable = [
        'estandar_id', 'user_id', 'carta_id', 'tipo_validacion', 'comentario'
    ];
    //relación donde al validar las cartas se toma el id de la carta
    public function cartas()
    {
        return $this->belongsTo(CartasDocumentos::class, 'carta_id');
    }
}
