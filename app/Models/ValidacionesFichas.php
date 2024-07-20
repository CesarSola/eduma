<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesFichas extends Model
{
    use HasFactory;
    protected $table = 'validaciones_fichas';

    protected $fillable = [
        'estandar_id', 'user_id', 'ficha_id', 'tipo_validacion', 'comentario'
    ];
    //relación donde al validar las fichas se toma el id de la ficha
    public function fichas()
    {
        return $this->belongsTo(FichasDocumentos::class, 'ficha_id');
    }
}
