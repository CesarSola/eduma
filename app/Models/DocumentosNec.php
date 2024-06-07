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


    ];
    public function estandares()
    {
        return $this->hasMany(Estandares::class, 'id');
    }
}
