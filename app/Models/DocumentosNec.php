<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosNec extends Model
{
    use HasFactory;

    protected $table = 'documentosnec';

    protected $fillable = [
        'id',
        'name',
        'description',
        'documento', // Asegúrate de incluir el campo correcto para la ruta del archivo
    ];

    public function estandares()
    {
        return $this->belongsToMany(Estandares::class, 'competencia_documentosnec', 'documentosnec_id', 'competencia_id',);
    }


    public function evidencias()
    {
        return $this->hasMany(DocumentosEvidencias::class, 'documento_id');
    }
    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_documentosnec', 'documentosnec_id', 'curso_id');
    }

    public function isSubidoPorUsuario($userId, $estandarId)
    {
        return $this->evidencias()
            ->where('user_id', $userId)
            ->whereHas('estandar', function ($query) use ($estandarId) {
                $query->where('id', $estandarId);
            })
            ->exists();
    }
}
