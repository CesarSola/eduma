<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\CompetenciasInscripciones;

class CompetenciasIncripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inscripciones = CompetenciasInscripciones::all();
        return view('inscripciones.index', compact('inscripciones'));
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
        // Validación de datos
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nombre_competencia' => 'required|string',
            // Agrega las reglas de validación para otros campos según sea necesario
        ]);

        // Crear una nueva inscripción
        $inscripcion = new CompetenciasInscripciones();
        $inscripcion->user_id = $request->user_id;
        $inscripcion->nombre_competencia = $request->nombre_competencia;
        $inscripcion->documentos_cargados = $request->documentos_cargados; // Aquí puedes manejar la lógica de almacenamiento de archivos
        $inscripcion->fecha_inscripcion = now(); // O cualquier otra lógica que desees utilizar para la fecha de inscripción
        $inscripcion->save();

        // Opcional: redireccionar o devolver una respuesta JSON
        return response()->json(['message' => 'Inscripción creada correctamente'], 201);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
