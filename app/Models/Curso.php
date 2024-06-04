<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    protected $table = 'cursos';
    public function estandares()
    {
        return $this->belongsTo(Estandares::class, 'id_estandares','id');
    }
}
