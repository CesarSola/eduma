<?php

namespace App\Http\Controllers;

use App\Models\Documentos;
use App\Models\Estandares;
use Illuminate\Http\Request;

class CompetenciasAddController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competencias =  Estandares::all();
        return view('lista_competencias.index',compact('competencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lista_competencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'numero' => 'nullable|string|max:200',
            'name' => 'required|string|max:255',
            'Dnecesarios' => 'required|string|max:255',
            'tipo' => 'required|string',
        ]);

        // Crear una nueva competencia
        Estandares::create([
            'numero' => $request->input('numero'),
            'Dnecesarios' => $request->input('Dnecesarios'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        // Redirigir a la misma página con un mensaje de éxito
        return back()->with('success', 'Competencia creada exitosamente');
    }


    /**
     * Display the specified resource.
     */
    /**
 * Display the specified resource.
 */
public function show(string $id)
{
    // Buscar la competencia por su ID
    $competencias = Estandares::findOrFail($id);
    $documentos = Documentos::all();
    // Retornar la vista de detalle de la competencia con los datos correspondientes
    return view('lista_competencias.show', compact('competencias','documentos'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validación de datos
        $request->validate([
            'numero' => 'nullable|string|max:200',
            'Dnecesarios' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tipo' => 'required|string',
        ]);

        // Buscar el curso por su ID
        $competencia = Estandares::findOrFail($id);

        $competencia->update([
            'numero' => $request->input('numero'),
            'Dnecesarios' => $request->input('Dnecesarios'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        return back()->with('success', 'Competencia actualizada exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
