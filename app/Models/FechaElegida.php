<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechaElegida extends Model
{
    use HasFactory;

    protected $table = 'fechas_horarios_elegidos';
    protected $fillable = ['user_id', 'fecha_competencia_id', 'horario_competencia_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fechaCompetencia()
    {
        return $this->belongsTo(FechaCompetencia::class);
    }
    public function horarioCompetencia()
    {
        return $this->belongsTo(Horario::class, 'horario_competencia_id');
    }
}
