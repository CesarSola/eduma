<?php

namespace App\Http\Controllers;

use App\Models\Diagnostico;
use Illuminate\Http\Request;

class DiagnosticoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagnosticos = Diagnostico::all();
        return view('Diagnosticos.index', compact('diagnosticos'));
    }
    public function show($id)
{
    $diagnostico = Diagnostico::findOrFail($id);
    return view('diagnosticos.show', compact('diagnostico'));
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $diagnostico = Diagnostico::findOrFail($id);
        return view('Diagnosticos.edit', compact('diagnostico'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $diagnosticos = Diagnostico::create($validatedData);

        return back()->with('success', 'Diagnostico creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'nombre' => 'nullable|string|max:255',

        ]);

            $diagnostico = Diagnostico::findOrFail($id);

        // Actualizar los datos del curso con los datos del formulario
        $diagnostico->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),

            'codigo' => $request->input('codigo'),

        ]);

            // Redirigir al usuario a la lista de cursos con un mensaje de éxito


        return redirect()->route('diagnosticos.index')->with('success', 'Diagnóstico actualizado exitosamente.');
    }
}
