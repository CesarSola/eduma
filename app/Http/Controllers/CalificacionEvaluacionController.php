<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\User;
use Illuminate\Http\Request;

class CalificacionEvaluacionController extends Controller
{
    public function show()
    {
        $users = User::where('role', 'User')->get();
        $estandares = Estandares::all();

        return view('expedientes.expedientesAdmin.competencias.calificacion.show', compact('users', 'estandares'));
    }
}
