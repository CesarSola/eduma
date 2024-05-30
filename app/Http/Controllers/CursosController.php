<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->user();
        $cursos = Curso::all();

        return view('lista_cursos.index', compact('usuario', 'cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lista_cursos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'plataforma' => 'nullable|string|max:255',
            'costo' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
        ]);

        // Crear un nuevo objeto Curso con los datos del formulario
        $curso = new Curso([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'instructor' => $request->input('instructor'),
            'duration' => $request->input('duration'),
            'modalidad' => $request->input('modalidad'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_final' => $request->input('fecha_final'),
            'plataforma' => $request->input('plataforma'),
            'costo' => $request->input('costo'),
            'certification' => $request->input('certification'),
        ]);

        // Guardar el curso en la base de datos
        $curso->save();

        // Redirigir al usuario a la lista de cursos con un mensaje de éxito
        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Buscar el curso por su ID
        $curso = Curso::findOrFail($id);

        // Mostrar el formulario de edición con los datos del curso
        return view('lista_cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'plataforma' => 'nullable|string|max:255',
            'costo' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
        ]);

        // Buscar el curso por su ID
        $curso = Curso::findOrFail($id);

        // Actualizar los datos del curso con los datos del formulario
        $curso->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'instructor' => $request->input('instructor'),
            'duration' => $request->input('duration'),
            'modalidad' => $request->input('modalidad'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_final' => $request->input('fecha_final'),
            'plataforma' => $request->input('plataforma'),
            'costo' => $request->input('costo'),
            'certification' => $request->input('certification'),
        ]);

        // Redirigir al usuario a la lista de cursos con un mensaje de éxito
        // Tu lógica para guardar el curso en el controlador

// Después de guardar el curso, redirige al usuario a la página de índice de cursos
return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');

    }

    // Otros métodos del controlador...
}
