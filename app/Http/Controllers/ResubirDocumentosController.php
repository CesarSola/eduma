<?php

namespace App\Http\Controllers;

use App\Models\DocumentosEvidencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResubirDocumentosController extends Controller
{
    public function show($id)
    {
        $evidencia = DocumentosEvidencias::with('estandar')->findOrFail($id);
        $usuario = User::findOrFail($evidencia->user_id); // Obtener el usuario relacionado

        // Verificar que $evidencia corresponde al estándar correcto
        return view('expedientes.expedientesUser.evidenciasEC.resubir.resubir', compact('evidencia', 'usuario'));
    }

    public function resubir(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ], [
            'file.max' => 'El archivo no puede exceder los 2MB.',
            'file.mimes' => 'Solo se permiten archivos en formato PDF.',
        ]);

        // Obtener la evidencia de documentos
        $evidencia = DocumentosEvidencias::findOrFail($id);

        // Obtener el documento relacionado
        $documento = $evidencia->documento;
        $user = Auth::user();

        // Obtener el estándar del documento
        $estandar = $evidencia->estandar;
        $estandar_id = $estandar ? $estandar->id : 'No disponible';
        $estandar_name = $estandar ? $estandar->name : 'No disponible';

        // Procesar y guardar el archivo resubido
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::slug($documento->name) . '.' . $file->getClientOriginalExtension();

            // Modificar la ruta para incluir la carpeta del estándar después de la matrícula del usuario
            $filePath = $file->storeAs(
                'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' . Str::slug($estandar->name),
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

        // Obtener el estándar del documento
        $estandar = $evidencia->estandar;
        $estandar_id = $estandar ? $estandar->id : 'No disponible';
        $estandar_name = $estandar ? $estandar->name : 'No disponible';


        // Redireccionar a la ruta correcta con los parámetros necesarios
        return redirect()->route('mis.evidencias', ['id' => $estandar_id, 'name' => $estandar_name])
            ->with('success', 'Documento resubido con éxito.');
    }
}
