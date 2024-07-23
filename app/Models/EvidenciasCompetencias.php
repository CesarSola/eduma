<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciasCompetencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'estandar_id',
        'documento_id',
        'file_path',
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
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
