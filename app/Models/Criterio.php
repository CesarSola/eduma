<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Termwind\Components\Element;

class Criterio extends Model
{
    protected $fillable = [
        'autodiagnostico_id',
        'nombre',
        'elemento_id'
    ];

    // Relación con Autodiagnóstico
    public function autodiagnostico()
    {
        return $this->belongsTo(AutoDiag::class);
    }
    public function elemento()
    {
        return $this->belongsTo(Elemento::class);
    }
    public function preguntas()
    {
        return $this->hasMany(PregAutDiag::class);
    }
    public function hasQuestions()
    {
        return $this->preguntas()->exists();
    }
}
