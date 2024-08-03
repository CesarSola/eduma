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
    // relacion con la tabla horarios(no se si lo sigo necesitando)
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'fecha_competencia_id');
    }
    // relacion con la tabla usuarios
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
