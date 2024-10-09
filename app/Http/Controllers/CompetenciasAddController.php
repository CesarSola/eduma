<?php

namespace App\Http\Controllers;

use App\Models\DocumentosNec;
use App\Models\Estandares;
use Illuminate\Http\Request;

class CompetenciasAddController extends Controller
{
    public function index()
    {
        $competencias = Estandares::all();
        $documentosnec = DocumentosNec::all();
        return view('lista_competencias.index', compact('competencias', 'documentosnec'));
    }

    public function create()
    {
        $documentosnec = DocumentosNec::all();
        return view('lista_competencias.create', compact('documentosnec'));
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'numero' => 'nullable|string|max:200',
            'name' => 'required|string|max:2550',
            'tipo' => 'required|string',
            'calificacion_minima' => 'nullable|numeric|min:0', // Añadido para validar la calificación mínima
            'documentosnec_id' => 'required|array',
            'documentosnec_id.*' => 'exists:documentosnec,id',
        ]);

        // Crear una nueva competencia con los datos validados
        $competencia = Estandares::create([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
            'calificacion_minima' => $request->input('calificacion_minima'), // Guardar la calificación mínima
            'documentos' => json_encode($request->input('documentosnec_id')), // Convierte el array a JSON
        ]);

        // Sincroniza los documentos con la relación
        $competencia->documentosnec()->sync($request->input('documentosnec_id'));

        // Redirigir con mensaje de éxito
        return redirect()->route('competenciasAD.index')->with('success', 'Competencia creada exitosamente');
    }

    public function update(Request $request, string $id)
    {
        // Validar los datos recibidos
        $request->validate([
            'numero' => 'nullable|string|max:200',
            'name' => 'required|string|max:2550',
            'tipo' => 'required|string',
            'calificacion_minima' => 'nullable|numeric|min:0', // Añadido para validar la calificación mínima
            'documentosnec_id' => 'required|array',
            'documentosnec_id.*' => 'exists:documentosnec,id',
        ]);

        // Encontrar la competencia por ID
        $competencia = Estandares::findOrFail($id);

        // Actualizar la competencia con los datos validados
        $competencia->update([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
            'calificacion_minima' => $request->input('calificacion_minima'), // Actualizar la calificación mínima
            'documentos' => json_encode($request->input('documentosnec_id')), // Convierte el array a JSON
        ]);

        // Sincroniza los documentos con la relación
        $competencia->documentosnec()->sync($request->input('documentosnec_id'));

        // Redirigir con mensaje de éxito
        return redirect()->route('competenciasAD.index')->with('success', 'Competencia actualizada exitosamente');
    }



    public function show(string $id)
    {
        $competencias = Estandares::findOrFail($id);

        return view('lista_competencias.show', compact('competencias'));
    }

    public function edit(string $id)
    {
        $competencia = Estandares::findOrFail($id);
        $documentosnec = DocumentosNec::all();
        return view('lista_competencias.edit', compact('competencia', 'documentosnec'));
    }

    public function destroy(string $id)
    {
        $competencia = Estandares::findOrFail($id);
        $competencia->delete();

        return back()->with('success', 'Competencia eliminada exitosamente');
    }

    public function storeDocumento(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crear un nuevo documento
        DocumentosNec::create([
            'name' => $request->input('name'),
        ]);

        // Redirigir a la página de edición con un mensaje de éxito
        return back()->with('success', 'Documento creado exitosamente');
    }
}
