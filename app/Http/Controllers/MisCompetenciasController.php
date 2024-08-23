<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\ValidacionesComprobantesCompetencias;
use Illuminate\Support\Facades\Auth;

class MisCompetenciasController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Obtén el ID del usuario autenticado

        // Obtener todos los estándares del usuario con comprobantes y validaciones
        $competencias = Estandares::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['comprobantesCO.validaciones'])
            ->get();

        // Obtener el usuario completo para usar en la vista
        $user = Auth::user();

        return view('expedientes.expedientesUser.competencias.index', compact('competencias', 'user'));
    }


    /**
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
    public function mostrarRechazado($id)
    {
        $competencia = Estandares::findOrFail($id);
        $validacionComentario = ValidacionesComprobantesCompetencias::where('comprobante_id', $competencia->id)
            ->where('comprobante_id', 'tipo_validacion')
            ->first();

        // Obtener las validaciones de comprobantes para las competencias del usuario
        $validacionesComentarios = ValidacionesComprobantesCompetencias::whereIn('comprobante_id', $competencia->pluck('id'))
            ->where('tipo_documento', 'comprobante')
            ->with('usuario')
            ->get()
            ->keyBy('comprobante_id');

        // Pasar los datos a la vista correspondiente
        return view('expedientes.expedientesUser.competencias.index', compact('competencias', 'validacionesComentarios'));
    }
}
