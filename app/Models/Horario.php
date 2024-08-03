<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $table = 'horarios_competencias';
    protected $fillable = [
        'user_id',
        'competencia_id',
        'hora',
        'fecha_competencia_id', // Asegúrate de que esté aquí
    ];

    public function fechaCompetencia()
    {
        return $this->belongsTo(FechaCompetencia::class, 'fecha_competencia_id');
    }
    // Relación con la competencia (Estandares)
    public function competencia()
    {
        return $this->belongsTo(Estandares::class, 'competencia_id');
    }


    // Accesor para formatear la hora
    public function getHoraFormattedAttribute()
    {
        return Carbon::parse($this->hora)->format('H:i');
    }
}
