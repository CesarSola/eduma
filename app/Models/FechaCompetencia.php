<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechaCompetencia extends Model
{
    use HasFactory;

    protected $table = 'fechas_competencias'; // Nombre de tu tabla si es diferente

    protected $fillable = [
        'competencia_id',
        'fecha',
    ];

    // Relación con la competencia (Estandares)
    public function competencia()
    {
        return $this->belongsTo(Estandares::class, 'competencia_id');
    }
}
