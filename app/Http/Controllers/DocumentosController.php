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
        $registroGeneral = User::findOrFail($id);
        $documentos = $registroGeneral->documentos;
        $comprobantePago = $registroGeneral->comprobantes->firstWhere('comprobante_pago', '!=', null);

        foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre) {
            if ($request->has("documento_$documentoNombre")) {
                $documentos->$documentoNombre = $request->input("documento_$documentoNombre");
                // Guardar los comentarios si los hay
                $documentos->{"comentario_$documentoNombre"} = $request->input("comentario_$documentoNombre");
            }
        }

        if ($comprobantePago && $request->has('comprobante_pago')) {
            $comprobantePago->estado = $request->input('comprobante_pago');
            $comprobantePago->comentario = $request->input('comentario_comprobante_pago');
        }

        $documentos->save();
        if ($comprobantePago) {
            $comprobantePago->save();
        }

        return redirect()->back()->with('success', 'Documentos actualizados correctamente');
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
