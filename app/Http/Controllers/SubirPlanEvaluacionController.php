<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\PlanesEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class SubirPlanEvaluacionController extends Controller
{
    public function show($id) // Aceptar un parámetro $id para el estándar específico
    {
        // Obtener el estándar específico por ID
        $estandar = Estandares::findOrFail($id);

        // Pasar el estándar a la vista
        return view('expedientes.expedientesUser.evidenciasEC.PlanEvaluacion.show', compact('estandar'));
    }
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

            // Construir la ruta del archivo
            $directoryPath = 'public/documents/evidence/competencias/evaluaciones/' .
                $user->matricula . '/' .
                Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname) . '/' .
                Str::slug($estandar->name);

            // Asegurarse de que el directorio existe
            Storage::makeDirectory($directoryPath);

            // Guardar el archivo en la ruta especificada
            $filePath = $file->storeAs($directoryPath, $fileName);

            // Crear un nuevo registro en la base de datos
            $documento = new PlanesEvaluacion();
            $documento->user_id = $user->id;
            $documento->estandar_id = $request->input('estandar_id');
            $documento->nombre = $request->input('nombre');
            $documento->file_path = $filePath;
            $documento->nombre_usuario = $user->name;
            $documento->save();

            // Redirigir a la vista 'evidenciasEC.index' con el mensaje de éxito
            return redirect()->route('evidenciasEC.index', [
                'id' => $request->input('estandar_id'),
                'name' => $estandar->name
            ])->with('success', 'Plan de evaluación subido exitosamente.');
        }

        // Si no se subió ningún archivo, redirigir a la misma vista 'evidenciasEC.index' con un mensaje de error
        return redirect()->route('evidenciasEC.index', [
            'id' => $request->input('estandar_id'),
            'name' => $estandar->name
        ])->with('error', 'No se ha subido ningún archivo.');
    }
}
