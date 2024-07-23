<?php

namespace App\Http\Controllers;

use App\Models\DocumentosEvidencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ValidacionesFichas;
use Illuminate\Support\Str;

class ResubirDocumentosController extends Controller
{
    public function show($id)
    {
        $evidencia = DocumentosEvidencias::findOrFail($id);
        $usuario = User::findOrFail($evidencia->user_id); // Obtener el usuario relacionado

        return view('expedientes.expedientesUser.evidenciasEC.resubir.resubir', compact('evidencia', 'usuario'));
    }


    public function resubir(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Obtener la evidencia de documentos
        $evidencia = DocumentosEvidencias::findOrFail($id);

        // Obtener el documento relacionado
        $documento = $evidencia->documento;
        $user = auth()->user();

        // Procesar y guardar el archivo resubido
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::slug($documento->name) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs(
                'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' . Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname),
                $fileName
            );

            // Actualizar el campo correspondiente en la base de datos
            $evidencia->file_path = $filePath;
            $evidencia->estado = 'pendiente'; // Cambiar el estado a 'pendiente'
            $evidencia->save();
        }

        // Actualizar el estado en validaciones_evidencias
        $validaciones = $evidencia->validacionesEvidencias;
        foreach ($validaciones as $validacion) {
            $validacion->tipo_validacion = 'pendiente'; // Ajusta esto si tienes un campo específico para el estado
            $validacion->save();
        }

        // Redireccionar a la ruta correcta con los parámetros necesarios
        $estandar_id = $documento->estandares->first()->id;
        $estandar_name = $documento->estandares->first()->name;

        return redirect()->route('evidenciasEC.index', ['id' => $estandar_id, 'name' => $estandar_name])
            ->with('success', 'Documento resubido con éxito.');
    }
}
