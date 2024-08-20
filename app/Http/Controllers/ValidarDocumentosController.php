<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\User;
use App\Models\ValidacionesEvidencias;
use Illuminate\Http\Request;

class ValidarDocumentosController extends Controller
{
    public function show($user_id, $documento_id)
    {
        $usuario = User::with('documentosE')->findOrFail($user_id);
        $competencia = Estandares::findOrFail($documento_id);

        // Filtrar documentos que están pendientes
        $documentos = $usuario->documentosE->filter(function ($documento) use ($documento_id) {
            $estado = json_decode($documento->estado, true) ?? [];
            return $documento->estandar_id == $documento_id && (!isset($estado[$documento->nombre]) || $estado[$documento->nombre] == 'pendiente');
        });

        return view('expedientes.expedientesAdmin.competencias.documentos.validar', compact('usuario', 'documentos', 'competencia'));
    }

    public function updateDocumento(Request $request, $id, $competencia_id)
    {
        // Encontrar al usuario y el documento relacionados
        $usuario = User::findOrFail($id);
        $documento = $usuario->documentosE()->findOrFail($competencia_id);

        // Procesar la actualización
        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Actualizar o crear validación
        ValidacionesEvidencias::updateOrCreate(
            [
                'user_id' => $usuario->id,
                'documento_id' => $documento->id,
                'estandar_id' => $documento->estandar_id
            ],
            [
                'tipo_validacion' => $accion,
                'comentario' => $comentario
            ]
        );

        // Actualizar estado del documento
        $estado = json_decode($documento->estado, true) ?? [];
        $estado[$documento->nombre] = $accion;
        $documento->update(['estado' => json_encode($estado)]);

        // Verificar si todos los documentos han sido validados
        $todosValidados = $usuario->documentosE->every(function ($doc) {
            $estado = json_decode($doc->estado, true) ?? [];
            return isset($estado[$doc->nombre]) && $estado[$doc->nombre] != 'pendiente';
        });

        // Responder
        $mensaje = $accion == 'validar' ? 'Documento validado correctamente' : 'Documento rechazado correctamente';
        return response()->json([
            'success' => $mensaje,
            'todos_validados' => $todosValidados
        ]);
    }
}
