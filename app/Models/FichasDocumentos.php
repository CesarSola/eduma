<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichasDocumentos extends Model
{
    use HasFactory;

    protected $table = 'fichas_documentos';

    protected $fillable = [
        'nombre', 'file_path', 'estandar_id', 'user_id', 'estado'
    ];

    // Relación con EvidenciasCompetencias (muchos a muchos)
    public function evidencias()
    {
        return $this->hasMany(ValidacionesFichas::class, 'ficha_id');
    }
    //relación donde la ficha toma el id del estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id', 'id');
    }
}
