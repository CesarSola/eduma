<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\DocumentosEvidencias;
use App\Models\FichasDocumentos;
use App\Models\User;
use App\Models\ValidacionesEvidencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvidenciasCompetenciasController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $competencia = $request->query('competencia');

        $usuario = $userId ? User::findOrFail($userId) : auth()->user();

        // Obtener documentos
        $documentos = DocumentosEvidencias::where('user_id', $usuario->id)
            ->where('estandar_id', $competencia)
            ->with('documento', 'estandar') // Asegúrate de que estas relaciones estén correctamente definidas
            ->get();

        // Obtener fichas
        $fichas = FichasDocumentos::where('user_id', $usuario->id)
            ->where('estandar_id', $competencia)
            ->get();

        // Obtener cartas
        $cartas = CartasDocumentos::where('user_id', $usuario->id)
            ->where('estandar_id', $competencia)
            ->get();

        // Combina todos los resultados en una sola colección
        $evidencias = $documentos->merge($fichas)->merge($cartas);

        return view('expedientes.expedientesAdmin.competencias.evidencias', compact('usuario', 'documentos', 'fichas', 'cartas', 'evidencias', 'competencia'));
    }

    public function updateEvidencia(Request $request, $id, $evidenciaId)
    {
        // Buscar el usuario por ID
        $usuario = User::findOrFail($id);

        // Buscar la evidencia de competencia por ID
        $evidencia = DocumentosEvidencias::findOrFail($evidenciaId);

        // Obtener la acción (validar/rechazar) y el comentario del request
        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que la evidencia pertenezca al usuario
        if ($evidencia->user_id == $usuario->id) {
            // Actualizar o crear la validación en la tabla de validaciones_evidencias
            $validacion = ValidacionesEvidencias::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                    'evidencia_id' => $evidenciaId,
                    'ficha_id' => null, // Asegúrate de ajustar esto según tus necesidades
                    'carta_id' => null, // Asegúrate de ajustar esto según tus necesidades
                ],
                [
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario,
                ]
            );

            // Preparar el mensaje de respuesta
            $mensaje = $accion === 'validar'
                ? ($validacion->wasRecentlyCreated ? 'Evidencia validada correctamente' : 'Evidencia actualizada y validada correctamente')
                : ($validacion->wasRecentlyCreated ? 'Evidencia rechazada correctamente' : 'Evidencia actualizada y rechazada correctamente');

            // Retornar una respuesta JSON con el mensaje apropiado
            return response()->json(['success' => $mensaje]);
        } else {
            // Si el usuario no tiene permiso para modificar esta evidencia, devolver un error 403
            return response()->json(['error' => 'No tienes permiso para modificar esta evidencia.'], 403);
        }
    }
}
