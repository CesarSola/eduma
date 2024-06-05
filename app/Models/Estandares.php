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
    public function cursos()
    {
        return $this->belongsTo(Curso::class, 'id');
    }
    public function comprobantePago()
    {
        return $this->hasOne(ComprobantePago::class);
    }
}
