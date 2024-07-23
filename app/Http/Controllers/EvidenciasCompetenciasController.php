<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\DocumentosEvidencias;
use App\Models\Estandares;
use App\Models\FichasDocumentos;
use App\Models\User;
use App\Models\ValidacionesCartas;
use App\Models\ValidacionesEvidencias;
use App\Models\ValidacionesFichas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvidenciasCompetenciasController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->query('user_id');
        $competenciaId = $request->query('competencia'); // Suponiendo que es un ID

        // Obtener el usuario
        $usuario = $userId ? User::findOrFail($userId) : auth()->user();

        // Obtener la competencia (estándar)
        $competencia = Estandares::findOrFail($competenciaId);

        // Obtener documentos
        $documentos = DocumentosEvidencias::where('user_id', $usuario->id)
            ->where('estandar_id', $competenciaId)
            ->with('documento', 'estandar')
            ->get();

        // Obtener fichas
        $fichas = FichasDocumentos::where('user_id', $usuario->id)
            ->where('estandar_id', $competenciaId)
            ->get();

        // Obtener cartas
        $cartas = CartasDocumentos::where('user_id', $usuario->id)
            ->where('estandar_id', $competenciaId)
            ->get();

        // Obtener validaciones de fichas
        $fichas_validaciones = ValidacionesFichas::where('user_id', $usuario->id)
            ->where('estandar_id', $competenciaId)
            ->get()
            ->keyBy('ficha_id');

        // Obtener validaciones de cartas
        $cartas_validaciones = ValidacionesCartas::where('user_id', $usuario->id)
            ->where('estandar_id', $competenciaId)
            ->get()
            ->keyBy('carta_id');

        // Combina todos los resultados en una sola colección
        $evidencias = $documentos->merge($fichas)->merge($cartas);

        return view('expedientes.expedientesAdmin.competencias.evidencias', compact(
            'usuario',
            'documentos',
            'fichas_validaciones',
            'cartas_validaciones',
            'fichas',
            'cartas',
            'evidencias',
            'competencia'
        ));
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
