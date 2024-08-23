<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\JuiciosUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class JuiciosUsuarioController extends Controller
{
    public function show($id) // Aceptar un parámetro $id para el estándar específico
    {
        // Obtener el estándar específico por ID
        $estandar = Estandares::findOrFail($id);

        // Pasar el estándar a la vista
        return view('expedientes.expedientesUser.evidenciasEC.juicio.show', compact('estandar'));
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

        $user = Auth::user();
        $estandar = Estandares::findOrFail($request->input('estandar_id'));

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::slug($request->input('nombre')) . '.' . $file->getClientOriginalExtension();

            $directoryPath = 'public/documents/evidence/competencias/juicios/' .
                $user->matricula . '/' .
                Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname) . '/' .
                Str::slug($estandar->name);

            Storage::makeDirectory($directoryPath);

            $filePath = $file->storeAs($directoryPath, $fileName);

            $documento = new JuiciosUsuario();
            $documento->user_id = $user->id;
            $documento->estandar_id = $request->input('estandar_id');
            $documento->nombre = $request->input('nombre');
            $documento->file_path = $filePath;

            $nombreUsuario = trim($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname);

            $documento->nombre_usuario = $nombreUsuario;
            $documento->save();

            return redirect()->route('evidenciasEC.index', [
                'id' => $request->input('estandar_id'),
                'name' => $estandar->name
            ])->with('success', 'Juicio de competencia subido exitosamente.');
        }

        return redirect()->route('evidenciasEC.index', [
            'id' => $request->input('estandar_id'),
            'name' => $estandar->name
        ])->with('error', 'No se ha subido ningún archivo.');
    }
}
