<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_curso');
    }
}
