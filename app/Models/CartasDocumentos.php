<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartasDocumentos extends Model
{
    use HasFactory;

    protected $table = 'cartas_documentos';

    protected $fillable = [
        'nombre', 'file_path', 'estandar_id', 'user_id', 'estado'
    ];


    // Relación con EvidenciasCompetencias (muchos a muchos)
    public function evidencias()
    {
        return $this->hasMany(ValidacionesCartas::class, 'carta_id');
    }
    //relación donde la carta toma el id del estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id', 'id');
    }
}
