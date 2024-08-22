<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostico extends Model
{
    use HasFactory;

    protected $table = 'diagnosticos';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
    ];

    // Relación con el modelo User a través de la tabla pivot diagnostico_user
    public function users()
    {
        return $this->belongsToMany(User::class, 'diagnostico_user', 'diagnostico_id', 'user_id')
                    ->withPivot('user_name', 'diagnostico_code');
    }

    // Relación con el modelo Estandares a través de la tabla pivot diagnostico_estandar
    public function estandares()
    {
        return $this->belongsToMany(Estandares::class, 'diagnostico_estandar', 'diagnostico_id', 'estandar_id');
    }
    public function estandar()
    {
        return $this->belongsTo(Estandares::class);
    }
}
