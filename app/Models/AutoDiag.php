<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoDiag extends Model
{
    use HasFactory;
    protected $table = 'autodiagnosticos';
    protected $fillable = [
        'titulo',
        'descripcion',
        'estandar_id',
        'elementos',
    ];
    public function preguntas()
    {
        return $this->hasMany(PregAutDiag::class); // Asegúrate que 'PregAutDiag' es el modelo correcto para tus preguntas
    }

    // Relación con Criterios
    public function criterios()
    {
        return $this->hasMany(Criterio::class, 'autodiagnostico_id');
    }
    // En tu modelo AutoDiag
    public function elementos()
    {
        return $this->hasMany(Elemento::class, 'autodiagnostico_id');
    }

    // Definir la relación con Estandares
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id');
    }
}
