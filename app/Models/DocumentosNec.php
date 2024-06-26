<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosNec extends Model
{
    use HasFactory;

    protected $table = 'documentosnec';

    protected $fillable = [
        'name',
        'description',
        'documento', // Asegúrate de incluir el campo correcto para la ruta del archivo
    ];

    public function estandares()
    {
        return $this->belongsToMany(Estandares::class, 'competencia_documentosnec', 'documentosnec_id', 'competencia_id');
    }
    public function evidencias()
    {
        return $this->hasMany(EvidenciasCompetencias::class, 'documento_id');
    }
}
