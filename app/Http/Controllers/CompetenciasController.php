<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estandares;

class CompetenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->user();
        $competencia = Estandares::all();

        return view('lista_estandares.index', compact('usuario', 'competencia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lista_estandares.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'tipo' => 'required|string',

        ]);

        // Crear un nuevo objeto Curso con los datos del formulario
        $competencia = new Estandares([
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),

        ]);

        // Guardar el curso en la base de datos
        $competencia->save();

        // Redirigir al usuario a la lista de cursos con un mensaje de éxito
        return redirect()->route('competencias.index')->with('success', 'competencias creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $competencia =  Estandares::findOrFail($id);

        // Mostrar el formulario de edición con los datos del curso
        return view('lista_competencias.edit', compact('competencias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'tipo' => 'required|string',

        ]);

        // Buscar el curso por su ID
        $competencia = Estandares::findOrFail($id);


        $competencia->update([
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),

        ]);



return redirect()->route('competencias.index')->with('success', 'competencia creado exitosamente');

    }

    // Otros métodos del controlador...
}
