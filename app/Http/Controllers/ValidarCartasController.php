<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\Estandares;
use App\Models\User;
use App\Models\ValidacionesCartas;
use App\Models\ValidacionesEvidencias;
use Illuminate\Http\Request;

class ValidarCartasController extends Controller
{
    public function show($user_id, $competencia)
    {
        // Obtener al usuario con sus fichas de documentos
        $usuario = User::with(['cartas'])->findOrFail($user_id);

        // Obtener la competencia correspondiente
        $competencia = Estandares::findOrFail($competencia);

        // Filtrar las fichas de documentos según las validaciones
        $cartasDocumentos = $usuario->cartas->filter(function ($carta) {
            return $carta->evidencias->isEmpty() || $carta->evidencias->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.competencias.cartas.validar', compact('usuario', 'cartasDocumentos', 'competencia'));
    }

    public function updateCarta(Request $request, $id, $cartaId)
    {
        $usuario = User::findOrFail($id);
        $carta = $usuario->cartas()->findOrFail($cartaId);

        // Procesar la actualización
        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Actualizar o crear validación
        ValidacionesCartas::updateOrCreate(
            [
                'user_id' => $usuario->id,
                'carta_id' => $carta->id,
                'estandar_id' => $carta->estandar_id
            ],
            [
                'tipo_validacion' => $accion,
                'comentario' => $comentario
            ]
        );

        // Actualizar estado de la ficha
        $estado = json_decode($carta->estado, true) ?? [];
        $estado[$carta->nombre] = $accion;
        $carta->update(['estado' => json_encode($estado)]);

        // Responder
        $mensaje = $accion == 'validar' ? 'Documento validado correctamente' : 'Documento rechazado correctamente';
        return response()->json(['success' => $mensaje]);
    }
}
