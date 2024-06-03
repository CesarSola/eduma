<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosUser extends Model
{
    use HasFactory;

    protected $table = 'documentos_user';

    protected $fillable = [
        'user_id',
        'foto',
        'ine_ife',
        'comprobante_domiciliario',
        'curp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
