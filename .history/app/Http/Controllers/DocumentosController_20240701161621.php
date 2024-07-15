<?php

namespace App\Http\Controllers;

use App\Models\DocumentosUser;
use App\Models\User;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($userId)
    {
        // Obtener todos los documentos del usuario seleccionado
        $documentos = DocumentosUser::where('user_id', $userId)->get();

        // Obtener el nombre del usuario
        $nombreUsuario = User::findOrFail($userId)->name;

        return view('expedientes.expedientesAdmin.registroGeneral.index', compact('documentos', 'nombreUsuario'));
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
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'ine_ife' => 'required|mimes:pdf|max:2048',
            'comprobante_domiciliario' => 'required|mimes:pdf|max:2048',
            'curp' => 'required|mimes:pdf|max:2048',
        ]);

        $fotoPath = $request->file('foto')->store('uploads', 'public');
        $ineIfePath = $request->file('ine_ife')->store('uploads', 'public');
        $comprobanteDomiciliarioPath = $request->file('comprobante_domiciliario')->store('uploads', 'public');
        $curpPath = $request->file('curp')->store('uploads', 'public');

        DocumentosUser::create([
            'user_id' => Auth::id(),
            'foto' => $fotoPath,
            'ine_ife' => $ineIfePath,
            'comprobante_domiciliario' => $comprobanteDomiciliarioPath,
            'curp' => $curpPath,
            'estado' => json_encode([]),
        ]);

        return redirect()->back()->with('success', 'Documentos subidos correctamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener todos los documentos y el comprobante de pago
        $registroGeneral = User::with(['documentos', 'comprobantes'])->findOrFail($id);

        // Filtrar documentos específicos
        $documentos = $registroGeneral->documentos;

        // Determinar el estado de los documentos
        $estadoDocumentos = [
            'validado' => [],
            'en_proceso' => [],
            'sin_documentos' => true,
        ];

        foreach ($documentos as $documento) {
            $documentoEstado = json_decode($documento->estado, true) ?? [];

            foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre) {
                if (isset($documento->$documentoNombre)) {
                    $estadoDocumentos['sin_documentos'] = false;
                    if (isset($documentoEstado[$documentoNombre]) && $documentoEstado[$documentoNombre] == 'validar') {
                        $estadoDocumentos['validado'][] = $documentoNombre;
                    } else {
                        $estadoDocumentos['en_proceso'][] = $documentoNombre;
                    }
                }
            }
        }

        return view('expedientes.expedientesAdmin.registroGeneral.show', compact('registroGeneral', 'documentos', 'estadoDocumentos'));
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
