<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estandares extends Model
{
    use HasFactory;

    protected $table = 'estandares';

    protected $fillable = [
        'numero', // existing fields
        'name', // existing fields
        'tipo',
        'Dnecesarios' // new field added
    ];

    // Relación muchos a uno con el modelo Curso
    public function cursos()
    {
        return $this->belongsTo(Curso::class, 'id');
    }

    // Relación uno a uno con el modelo ComprobantePago
    public function comprobantePago()
    {
        return $this->hasOne(ComprobantePago::class);
    }

    // Relación muchos a muchos con el modelo User
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_estandares', 'estandar_id', 'user_id');
    }
}
