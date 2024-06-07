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
        'documentosnec_id' // new field added
    ];



    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id');
    }

    public function documentosnec()
    {
        return $this->belongsTo(DocumentosNec::class,  'documentosnec_id');
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
