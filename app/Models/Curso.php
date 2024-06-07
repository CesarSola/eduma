<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $fillable = [

        'name', // existing fields
        'description',
        'id_estandar', // existing fields
        'instructor',
        'duration',
        'modalidad',
        'fecha_inicio',
        'fecha_final',
        'plataforma',
         'costo',
           'certification'

    ];

    public function estandares()
    {
        return $this->belongsTo(Estandares::class,  'id_estandar');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_curso');
    }
}
