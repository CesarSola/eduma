<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciasInscripciones extends Model
{
    use HasFactory;
    protected $table = 'inscripciones';

    protected $fillable = [
        'user_id',
        'nombre_competencia',
        'documentos_cargados',
        'fecha_inscripcion',
    ];

    // Relación con el modelo de Usuario (User)
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
