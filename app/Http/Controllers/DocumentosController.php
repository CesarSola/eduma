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
        // Obtener todos los documentos y el comprobante de pago
        $registroGeneral = User::with(['documentos', 'comprobantes'])->findOrFail($id);

        // Filtrar documentos específicos
        $documentos = $registroGeneral->documentos->filter(function ($documento) {
            return $documento->validacionesComentarios->isEmpty() || $documento->validacionesComentarios->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        // Filtrar comprobante de pago
        $comprobantePago = $registroGeneral->comprobantes->filter(function ($comprobante) {
            return $comprobante->validacionesComentarios->isEmpty() || $comprobante->validacionesComentarios->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        })->first();

        return view('expedientes.expedientesAdmin.registroGeneral.show', compact('registroGeneral', 'documentos', 'comprobantePago'));
    }

    public function updateDocumento(Request $request, $id, $documentoNombre)
    {
        $registroGeneral = User::findOrFail($id);
        $documentos = $registroGeneral->documentos;
        $comprobantes = $registroGeneral->comprobantes;

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        foreach ($documentos as $documento) {
            if (isset($documento->$documentoNombre)) {
                // Update or create validation
                ValidacionesComentarios::updateOrCreate(
                    [
                        'user_id' => $registroGeneral->id,
                        'documento_user_id' => $documento->id,
                        'tipo_documento' => $documentoNombre
                    ],
                    [
                        'tipo_validacion' => $accion,
                        'comentario' => $comentario
                    ]
                );

                // Update the validation status in the document's state
                $estado = json_decode($documento->estado, true) ?? [];
                $estado[$documentoNombre] = $accion;
                $documento->update(['estado' => json_encode($estado)]);
            }
        }

        foreach ($comprobantes as $comprobante) {
            if ($documentoNombre == 'comprobante_pago') {
                // Update or create validation for comprobante de pago
                ValidacionesComentarios::updateOrCreate(
                    [
                        'user_id' => $registroGeneral->id,
                        'comprobante_pago_id' => $comprobante->id,
                        'tipo_documento' => 'comprobante_pago'
                    ],
                    [
                        'tipo_validacion' => $accion,
                        'comentario' => $comentario
                    ]
                );

                // Update the validation status in the comprobante's state
                $estado = json_decode($comprobante->estado, true) ?? [];
                $estado['comprobante_pago'] = $accion;
                $comprobante->update(['estado' => json_encode($estado)]);
            }
        }

        // Return JSON response with appropriate message
        if ($accion == 'validar') {
            $mensaje = 'Documento validado correctamente';
        } else {
            $mensaje = 'Documento rechazado correctamente';
        }
        return response()->json(['success' => $mensaje]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
