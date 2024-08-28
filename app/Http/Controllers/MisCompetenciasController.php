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

        // Obtener todos los estándares del usuario con comprobantes y calificaciones
        $competencias = Estandares::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['comprobantesCO.validaciones', 'calificaciones' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])
            ->get();

        foreach ($competencias as $competencia) {
            $calificaciones = $competencia->calificaciones->first();
            $promedio = null;

            if ($calificaciones) {
                $evidencias = $calificaciones->evidencias ?? 0;
                $evaluacion = $calificaciones->evaluacion ?? 0;
                $presentacion = $calificaciones->presentacion ?? 0;

                $promedio = ($evidencias + $evaluacion + $presentacion) / 3;
                $promedio = $promedio * 10; // Escala de 1 a 10

                $calificacion_minima = $competencia->calificacion_minima;

                $competencia->mensaje = $promedio >= $calificacion_minima
                    ? 'Aprobado'
                    : 'No aprobado';
            }

            // Obtener el estado del comprobante
            $comprobantes = $competencia->comprobantesCO;
            $estado = 'no_validado';

            if ($comprobantes) {
                foreach ($comprobantes as $comprobante) {
                    $validacionComentarios = $comprobante->validaciones
                        ->where('user_id', $userId)
                        ->first();

                    if ($validacionComentarios) {
                        $estado = $validacionComentarios->tipo_validacion;
                        break;
                    }
                }
            }

            $competencia->estado = $estado;
            $competencia->promedio = $promedio;
        }

        return view('expedientes.expedientesUser.competencias.index', [
            'competencias' => $competencias,
            'user' => Auth::user()
        ]);
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
