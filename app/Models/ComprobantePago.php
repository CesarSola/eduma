<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobantePago extends Model
{
    use HasFactory;
    protected $table = 'comprobantes_pago';
    protected $fillable = [
        'user_id',
        'estandar_id',
        'comprobante_pago',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estandar()
    {
        return $this->belongsTo(Estandares::class);
    }
}
