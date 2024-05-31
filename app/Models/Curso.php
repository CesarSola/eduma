<?php
// app/Models/Curso.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'competencia',
        'instructor',
        'duration',
        'modalidad',
        'fecha_inicio',
        'fecha_final',
        'plataforma',
        'costo',
        'certification',
    ];
}

