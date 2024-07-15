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


    public function create()
    {
        return view('documentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'documentosnec_id' => 'required|array',
        ]);

        $documento = DocumentosUser::create([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        $documento->documentosnec()->attach($request->input('documentosnec_id'));

        return redirect()->route('documentos.index')->with('success', 'Documento creado exitosamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $documento = DocumentosUser::findOrFail($id);
        $documentosnec = DocumentosNec::all();

        return view('documentos.edit', compact('documento', 'documentosnec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'documentosnec_id' => 'required|array',
        ]);

        $documento = Documentos::findOrFail($id);
        $documento->update([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        $documento->documentosnec()->sync($request->input('documentosnec_id'));

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener todos los documentos y el comprobante de pago
        $registroGeneral = User::with(['documentos'])->findOrFail($id);

        // Filtrar documentos específicos
        $documentos = $registroGeneral->documentos->filter(function ($documento) {
            return $documento->validacionesComentarios->isEmpty() || $documento->validacionesComentarios->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.registroGeneral.show', compact('registroGeneral', 'documentos'));
    }

    public function updateDocumento(Request $request, $id, $documentoNombre)
    {
        $registroGeneral = User::findOrFail($id);
        $documentos = $registroGeneral->documentos;

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


        // Return JSON response with appropriate message
        if ($accion == 'validar') {
            $mensaje = 'Documento validado correctamente';
        } else {
            $mensaje = 'Documento rechazado correctamente';
        }
        return response()->json(['success' => $mensaje]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
