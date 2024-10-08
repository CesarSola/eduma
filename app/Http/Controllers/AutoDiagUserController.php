<?php

namespace App\Http\Controllers;

use App\Models\AutoDiag;
use App\Models\Criterio;
use App\Models\Elemento;
use App\Models\PregAutDiag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoDiagUserController extends Controller
{
    public function index()
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtén los autodiagnósticos disponibles para el usuario
            $autodiagnosticos = AutoDiag::all(); // Carga todos los autodiagnósticos

            // Cargar los elementos asociados a cada autodiagnóstico
            $elementos = Elemento::whereIn('autodiagnostico_id', $autodiagnosticos->pluck('id'))
                ->with('criterios.preguntas')
                ->get();

            // Cargar los criterios asociados a los elementos
            $criterios = Criterio::whereIn('elemento_id', $elementos->pluck('id'))
                ->with('preguntas')
                ->get();

            // Cargar las preguntas asociadas a los criterios
            $preguntas = PregAutDiag::whereIn('criterio_id', $criterios->pluck('id'))->get();

            // Retornar la vista con las variables necesarias
            return view('expedientes.autoDiagUser.index', compact('autodiagnosticos', 'elementos', 'criterios', 'preguntas'));
        } else {
            return redirect()->route('login'); // Redirige si no está autenticado
        }
    }
}
