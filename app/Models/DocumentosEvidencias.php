<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosEvidencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'estandar_id',
        'documento_id',
        'nombre',
        'file_path',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id');
    }

    public function documento()
    {
        return $this->belongsTo(DocumentosNec::class, 'documento_id');
    }

    public function validacionesEvidencias()
    {
        return $this->hasMany(ValidacionesEvidencias::class, 'documento_id');
    }


    // Función que cambia el estado del documento a pendiente cuando esté vacío o sea null
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->estado)) {
                $model->estado = 'pendiente'; // Establecer directamente el valor por defecto
            }
        });
    }
}
