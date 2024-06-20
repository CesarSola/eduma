<?php

namespace App\Http\Controllers;

use App\Models\Documentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentosUser;
use Illuminate\Support\Facades\Log;

class SDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expedientes.expedientesUser.documentosUser.index');
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
            'foto' => 'file|mimes:jpg,bmp,png,pdf|max:2048',
            'ine_ife' => 'file|mimes:jpg,bmp,png,pdf|max:2048',
            'comprobante_domiciliario' => 'file|mimes:jpg,bmp,png,pdf|max:2048',
            'curp' => 'file|mimes:jpg,bmp,png,pdf|max:2048',
        ]);

        $user = Auth::user();
        $userName = str_replace(' ', '_', $user->name);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->storeAs('public/images/documentos/' . $userName, 'Foto.' . $foto->extension());
        }

        if ($request->hasFile('ine_ife')) {
            $ineIfe = $request->file('ine_ife');
            $ineIfePath = $ineIfe->storeAs('public/images/documentos/' . $userName, 'INE_o_IFE.' . $ineIfe->extension());
        }

        if ($request->hasFile('comprobante_domiciliario')) {
            $comprobante = $request->file('comprobante_domiciliario');
            $comprobantePath = $comprobante->storeAs('public/images/documentos/' . $userName, 'Comprobante_Domicilio.' . $comprobante->extension());
        }

        if ($request->hasFile('curp')) {
            $curp = $request->file('curp');
            $curpPath = $curp->storeAs('public/images/documentos/' . $userName, 'CURP.' . $curp->extension());
        }

        $documentosUser = new DocumentosUser();
        $documentosUser->user_id = $user->id;
        $documentosUser->foto = $fotoPath ?? null;
        $documentosUser->ine_ife = $ineIfePath ?? null;
        $documentosUser->comprobante_domiciliario = $comprobantePath ?? null;
        $documentosUser->curp = $curpPath ?? null;
        $documentosUser->save();

        return redirect()->route('usuarios.index')->with('success', 'Documentos subidos correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($tipo_documento)
    {
        // Encuentra el documento del usuario actual por el tipo de documento
        $documento = DocumentosUser::where('user_id', auth()->id())->first();

        // Pasar los datos necesarios a la vista
        return view('expedientes.expedientesUser.documentosUser.edit', compact('documento', 'tipo_documento'));
    }

    public function update(Request $request, string $tipo_documento)
    {
        // Validar y guardar el documento resubido
        $documento = DocumentosUser::where('user_id', Auth::id())->firstOrFail();

        // Procesar el estado actual del documento
        $estado = json_decode($documento->estado, true) ?? [];

        // Verificar si ya hay un estado registrado para este tipo de documento
        if (isset($estado[$tipo_documento])) {
            // Si ya había un estado anteriormente y era 'rechazar', eliminarlo
            if ($estado[$tipo_documento] == 'rechazar') {
                unset($estado[$tipo_documento]);
            }
        }

        // Guardar el estado actualizado del documento
        $documento->estado = json_encode($estado);
        $documento->save();

        // Procesar y guardar el archivo resubido
        if ($request->hasFile($tipo_documento)) {
            $file = $request->file($tipo_documento);

            // Obtener el nombre del usuario y ajustar para el almacenamiento
            $user = Auth::user();
            $userName = str_replace(' ', '_', $user->name);

            // Almacenar el archivo en la carpeta correspondiente
            $filename = $tipo_documento . '.' . $file->extension(); // Nombre del archivo con extensión original
            $filePath = $file->storeAs('public/images/documentos/' . $userName, $filename); // Almacenar en la misma carpeta y nombre

            // Actualizar el campo correspondiente en la base de datos
            $documento->$tipo_documento = $filePath;
            $documento->save();
        }

        // Redireccionar o devolver una respuesta adecuada
        return redirect()->route('usuarios.index')->with('success', 'Documento resubido correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
