<?php

namespace App\Http\Controllers;

use App\Models\CedulaEvaluacion;
use App\Models\Estandares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CedulaEvaluacionController extends Controller
{
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'estandar_id' => 'required|exists:estandares,id',
            'nombre' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf|max:20480', // Ajustado para aceptar solo PDF hasta 20MB
        ], [
            'file.max' => 'El archivo no puede exceder los 20MB.',
            'file.mimes' => 'Solo se permiten archivos en formato PDF.',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();
        $estandar = Estandares::findOrFail($request->input('estandar_id'));

        // Procesar y guardar el archivo
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::slug($request->input('nombre')) . '.' . $file->getClientOriginalExtension();

            // Construir la ruta del archivo en 'storage/app/public'
            $directoryPath = 'public/documents/evidence/competencias/cedulas/' .
                $user->matricula . '/' .
                Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname) . '/' .
                Str::slug($estandar->name);

            Storage::makeDirectory($directoryPath);

            $filePath = $file->storeAs($directoryPath, $fileName);

            // Crear un nuevo registro en la base de datos
            $documento = new CedulaEvaluacion();
            $documento->user_id = $user->id;
            $documento->estandar_id = $request->input('estandar_id');
            $documento->nombre = $request->input('nombre');
            $documento->file_path = $filePath;

            // Concatenar todos los nombres y apellidos
            $nombreUsuario = trim($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname);

            // Guardar el nombre completo del usuario en el campo 'nombre_usuario'
            $documento->nombre_usuario = $nombreUsuario;
            $documento->save();

            // Redirigir a la vista 'evidenciasEC.index' con el mensaje de éxito
            return redirect()->route('evidenciasEC.index', [
                'id' => $request->input('estandar_id'),
                'name' => $estandar->name
            ])->with('success', 'Cédula de evaluación subido exitosamente.');
        }

        // Si no se subió ningún archivo, redirigir a la misma vista 'evidenciasEC.index' con un mensaje de error
        return redirect()->route('evidenciasEC.index', [
            'id' => $request->input('estandar_id'),
            'name' => $estandar->name
        ])->with('error', 'No se ha subido ningún archivo.');
    }
}
