<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanesEvaluacion extends Model
{
    use HasFactory;

    // Especificar la tabla asociada si el nombre de la tabla no sigue la convención de Laravel
    protected $table = 'planes_evaluacion';

    // Especificar los atributos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'estandar_id',
        'nombre',
        'file_path',
        'nombre_usuario',
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
