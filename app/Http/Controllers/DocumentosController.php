<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        // Log para verificar que se está obteniendo el usuario correctamente
        Log::info('ID de usuario: ' . $id);

        $registroGeneral = User::with(['documentos' => function ($query) {
            $query->where('estado', 'pendiente'); // Solo obtener documentos pendientes
        }, 'comprobantes' => function ($query) {
            $query->where('estado', 'pendiente'); // Solo obtener comprobantes pendientes
        }])->findOrFail($id);

        // Log para verificar que se están obteniendo los documentos correctamente
        Log::info('Documentos del usuario: ' . json_encode($registroGeneral->documentos));

        // Log para verificar que se está obteniendo el comprobante de pago correctamente
        Log::info('Comprobante de pago del usuario: ' . json_encode($registroGeneral->comprobantes));
        // Filtrar documentos específicos
        $documentos = $registroGeneral->documentos;

        // Filtrar comprobante de pago
        $comprobantePago = $registroGeneral->comprobantes->firstWhere('comprobante_pago', '!=', null);

        return view('expedientes.expedientesAdmin.registroGeneral.show', compact('registroGeneral', 'documentos', 'comprobantePago'));
    }

    public function updateDocumentos(Request $request, $id)
    {
        $registroGeneral = User::with(['documentos.validacionesComentarios', 'comprobantes.validacionesComentarios'])->findOrFail($id);
        $documentos = $registroGeneral->documentos;
        $comprobantes = $registroGeneral->comprobantes;

        foreach ($documentos as $documento) {
            foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre) {
                if ($request->has("documento_$documentoNombre")) {
                    $accion = $request->input("documento_$documentoNombre");
                    $comentario = $request->input("comentario_$documentoNombre", '');

                    // Actualizar solo las columnas relevantes del documento
                    $documento->update([
                        'estado' => $accion,
                    ]);

                    // Revisar si ya existe una validación para este documento
                    $validacionExistente = ValidacionesComentarios::where('user_id', $registroGeneral->id)
                        ->where('documento_user_id', $documento->id)
                        ->where('tipo_documento', $documentoNombre)
                        ->first();

                    if ($validacionExistente) {
                        // Actualizar la validación existente
                        $validacionExistente->update([
                            'tipo_validacion' => $accion,
                            'comentario' => $comentario,
                        ]);
                    } else {
                        // Crear una nueva entrada en la tabla validaciones_comentarios
                        ValidacionesComentarios::create([
                            'user_id' => $registroGeneral->id,
                            'documento_user_id' => $documento->id,
                            'tipo_documento' => $documentoNombre,
                            'tipo_validacion' => $accion,
                            'comentario' => $comentario,
                        ]);
                    }
                }
            }
        }

        foreach ($comprobantes as $comprobante) {
            if ($request->has('comprobante_pago')) {
                $accion = $request->input('comprobante_pago');
                $comentario = $request->input('comentario_comprobante_pago', '');

                $comprobante->update([
                    'estado' => $accion,
                ]);

                // Revisar si ya existe una validación para el comprobante de pago
                $validacionExistente = ValidacionesComentarios::where('user_id', $registroGeneral->id)
                    ->where('comprobante_pago_id', $comprobante->id)
                    ->where('tipo_documento', 'comprobante_pago')
                    ->first();

                if ($validacionExistente) {
                    // Actualizar la validación existente
                    $validacionExistente->update([
                        'tipo_validacion' => $accion,
                        'comentario' => $comentario,
                    ]);
                } else {
                    // Crear una nueva entrada en la tabla validaciones_comentarios
                    ValidacionesComentarios::create([
                        'user_id' => $registroGeneral->id,
                        'comprobante_pago_id' => $comprobante->id,
                        'tipo_documento' => 'comprobante_pago',
                        'tipo_validacion' => $accion,
                        'comentario' => $comentario,
                    ]);
                }
            }
        }

        // Actualizar el estado de los documentos basado en la última validación
        foreach ($documentos as $documento) {
            $lastValidation = $documento->validacionesComentarios->last();
            $nuevoEstado = $lastValidation ? $lastValidation->tipo_validacion : $documento->estado; // Mantener el estado actual si no hay validaciones
            $documento->update([
                'estado' => $nuevoEstado,
            ]);
        }

        // Actualizar el estado de los comprobantes basado en la última validación
        foreach ($comprobantes as $comprobante) {
            $lastValidation = $comprobante->validacionesComentarios->last();
            $nuevoEstado = $lastValidation ? $lastValidation->tipo_validacion : $comprobante->estado; // Mantener el estado actual si no hay validaciones
            $comprobante->update([
                'estado' => $nuevoEstado,
            ]);
        }

        return redirect()->route('usuariosAdmin.show', ['usuariosAdmin' => $registroGeneral->id])
            ->with('success', 'Documentos actualizados correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
