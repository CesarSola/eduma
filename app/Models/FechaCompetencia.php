<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechaCompetencia extends Model
{
    use HasFactory;

    protected $table = 'fechas_competencias'; // Nombre de tu tabla si es diferente

    protected $fillable = [
        'user_id',
        'competencia_id',
        'fecha',
    ];
    protected $casts = [
        'fecha' => 'datetime', // Esto convierte la columna 'fecha' en una instancia de Carbon
    ];

    // Relación con la competencia (Estandares)
    public function competencia()
    {
        return $this->belongsTo(Estandares::class, 'competencia_id');
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'fecha_competencia_id');
    }
}
