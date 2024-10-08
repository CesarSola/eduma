<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    use HasFactory;

    protected $fillable = [
        'autodiagnostico_id',
        'nombre',
    ];

    public function autodiagnostico()
    {
        return $this->belongsTo(AutoDiag::class, 'autodiagnostico_id');
    }

    public function criterios()
    {
        return $this->hasMany(Criterio::class, 'elemento_id'); // Asumiendo que tienes una relación en la tabla de criterios
    }
    public function preguntas()
    {
        return $this->hasMany(PregAutDiag::class);
    }
}
