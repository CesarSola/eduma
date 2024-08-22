<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuiciosUsuario extends Model
{
    use HasFactory;

    protected $table = 'juicios_usuario'; // Especificar el nombre de la tabla si es diferente al nombre del modelo en plural

    protected $fillable = [
        'user_id',
        'nombre_usuario',
        'estandar_id',
        'nombre',
        'file_path',
    ];
    // Definir las relaciones, si las hay
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estandar()
    {
        return $this->belongsTo(Estandares::class);
    }
}
