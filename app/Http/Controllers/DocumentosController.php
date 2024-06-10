<?php

namespace App\Http\Controllers;

use App\Models\DocumentosUser;
use App\Models\User;
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
        $registroGeneral = User::with('documentos', 'comprobantes')->findOrFail($id);

        // Filtrar documentos específicos
        $documentos = $registroGeneral->documentos;

        // Filtrar comprobante de pago
        $comprobantePago = $registroGeneral->comprobantes->firstWhere('comprobante_pago', '!=', null);

        return view('expedientes.expedientesAdmin.registroGeneral.show', compact('registroGeneral', 'documentos', 'comprobantePago'));
    }

    public function updateDocumentos(Request $request, $id)
    {
        // Obtener el usuario con sus documentos
        $registroGeneral = User::findOrFail($id);
        $documentos = $registroGeneral->documentos;

        // Iterar sobre cada documento individualmente
        foreach ($documentos as $documento) {
            foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre) {
                // Verificar si hay una acción (validar o rechazar) para el documento actual
                if ($request->has("documento_$documentoNombre")) {
                    // Obtener la acción (validar o rechazar)
                    $accion = $request->input("documento_$documentoNombre");

                    // Obtener el comentario asociado al documento si existe
                    $comentarioCampo = "comentario_$documentoNombre";
                    $comentario = $request->input($comentarioCampo, '');

                    // Actualizar solo las columnas relevantes del documento
                    $documento->update([
                        'estado' => $accion,
                        'comentario' => $comentario,
                    ]);
                }
            }
        }

        // Redirigir de vuelta a la vista de detalle del usuario
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
