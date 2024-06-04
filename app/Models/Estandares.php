<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estandares extends Model
{
    use HasFactory;
    protected $table = 'estandares';
    public function cursos()
    {
        return $this->belongsTo(Curso::class, 'id');
    }
}
