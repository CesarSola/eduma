<?php

namespace App\Http\Controllers;

use App\Models\ValidacionesComprobantesCompetencias;
use Illuminate\Support\Facades\Auth;

class MisCompetenciasController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();

        // Obtener las competencias (estándares) inscritas por el usuario autenticado
        $competencias = $usuario->estandares;

        // Obtener las validaciones de comprobantes para las competencias del usuario
        $validacionesComentarios = ValidacionesComprobantesCompetencias::whereIn('comprobante_id', $competencias->pluck('id'))
            ->where('tipo_documento', 'comprobante')
            ->with('usuario')
            ->get()
            ->keyBy('comprobante_id');

        // Pasar los datos a la vista correspondiente
        return view('expedientes.expedientesUser.competencias.index', compact('competencias', 'validacionesComentarios'));
    }
}
