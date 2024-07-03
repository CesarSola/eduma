<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estandares extends Model
{
    use HasFactory;

    protected $table = 'estandares';

    protected $fillable = [
        'numero',
        'name',
        'tipo'
    ];

    public function cursos()
    {
        return $this->hasMany(Curso::class, 'id');
    }

    public function documentosnec()
    {
        return $this->belongsToMany(DocumentosNec::class, 'competencia_documentosnec', 'competencia_id', 'documentosnec_id');
    }

    // Estandares.php

    public function comprobantesCO()
    {
        return $this->hasOne(comprobantesCO::class, 'estandar_id', 'id');
    }


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_estandares', 'estandar_id', 'user_id');
    }
    public function estandares()
    {
        return $this->hasMany(Estandares::class);
    }
    public function validacionesComentarios()
    {
        return $this->hasMany(ValidacionesComentarios::class, 'comprobanteCO_id', 'id');
    }
}
