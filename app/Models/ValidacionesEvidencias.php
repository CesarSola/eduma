<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidacionesEvidencias extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'validaciones_documentos';
    protected $fillable = [
        'user_id',
        'estandar_id',
        'documento_id',
        'tipo_validacion',
        'comentario',
    ];

    /**
     * Get the user that owns the validation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the evidence associated with the validation.
     */
    public function evidencia()
    {
        return $this->belongsToMany(DocumentosEvidencias::class, 'documento_id');
    }
    public function documentoEvidencia()
    {
        return $this->belongsTo(DocumentosEvidencias::class, 'documento_id');
    }
}
