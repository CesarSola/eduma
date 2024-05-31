<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'path',
    ];

    // Relación inversa con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
