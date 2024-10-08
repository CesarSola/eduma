<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregAutDiag extends Model
{
    use HasFactory;

    protected $table = 'preguntas'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'titulo',
        'pregunta',
        'resp_correcta',
        'autodiagnostico_id',
        'elemento_id',
        'criterio_id'
    ];

    // Relación con el autodiagnóstico
    public function autodiagnostico()
    {
        return $this->belongsTo(AutoDiag::class);
    }

    // Relación con el elemento
    public function elemento()
    {
        return $this->belongsTo(Elemento::class);
    }

    // Relación con el criterio
    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }
}
