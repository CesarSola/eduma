<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'exam_date',
        'logo',
        'question1',
        'question2',
        'question3',
        'question4',
        'question5',
        'question6',
        'question7',
        'question8',
        'doubts',
        'user_id', 
        
        'estandar_id',// Asegúrate de agregar 'user_id' aquí
    ];

    // Define la relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define la relación con el modelo Estandares
    public function estandar()
    {
        return $this->belongsTo(Estandares::class, 'estandar_id');
    }
}
