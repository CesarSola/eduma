<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FichasDocumentos;
use App\Models\User;
use App\Models\ValidacionesFichas;
use Illuminate\Http\Request;

class ValidarFichasController extends Controller
{
    public function show($user_id, $competencia)
    {
        // Obtener al usuario con sus fichas de documentos
        $usuario = User::with(['fichas'])->findOrFail($user_id);

        // Obtener la competencia correspondiente
        $competencia = Estandares::findOrFail($competencia);

        // Filtrar las fichas de documentos según las validaciones
        $fichasDocumentos = $usuario->fichas->filter(function ($ficha) {
            return $ficha->evidencias->isEmpty() || $ficha->evidencias->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.competencias.fichas.validar', compact('usuario', 'fichasDocumentos', 'competencia'));
    }

    public function updateFicha(Request $request, $id, $fichaId)
    {
        $request->validate([
            'documento_estado' => 'required|string|in:validar,rechazar',
            'comentario_documento' => 'nullable|string|max:255',
        ]);

        $usuario = User::findOrFail($id);
        $ficha = $usuario->fichas()->findOrFail($fichaId);

        // Procesar la actualización
        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Actualizar o crear validación
        ValidacionesFichas::updateOrCreate(
            [
                'user_id' => $usuario->id,
                'ficha_id' => $ficha->id,
                'estandar_id' => $ficha->estandar_id
            ],
            [
                'tipo_validacion' => $accion,
                'comentario' => $comentario
            ]
        );

        // Actualizar estado de la ficha
        $estado = json_decode($ficha->estado, true) ?? [];
        $estado[$ficha->nombre] = $accion;
        $ficha->update(['estado' => json_encode($estado)]);

        // Responder
        $mensaje = $accion == 'validar' ? 'Documento validado correctamente' : 'Documento rechazado correctamente';
        return response()->json(['success' => $mensaje]);
    }
}
