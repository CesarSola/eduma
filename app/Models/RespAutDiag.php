<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespAutDiag extends Model
{
    use HasFactory;

    // Define la tabla asociada con el modelo
    protected $table = 'resp_aut_diag';

    // Especifica los atributos que son asignables en masa
    protected $fillable = [
        'usuario_id',
        'estandar_id',
        'autodiagnostico_id',
        'elemento_id',
        'criterio_id',
        'pregunta_id',
        'respuesta',
        'correcta', // Agrega este campo si decides tenerlo para almacenar si la respuesta es correcta
    ];

    // Definir la relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    // Definir la relación con el modelo Estandar
    public function estandar()
    {
        return $this->belongsTo(Estandares::class);
    }

    // Definir la relación con el modelo AutoDiagnostico
    public function autodiagnostico()
    {
        return $this->belongsTo(AutoDiag::class);
    }

    // Definir la relación con el modelo Elemento
    public function elemento()
    {
        return $this->belongsTo(Elemento::class);
    }

    // Definir la relación con el modelo Criterio
    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }

    // Definir la relación con el modelo Pregunta
    public function pregunta()
    {
        return $this->belongsTo(PregAutDiag::class);
    }
}
