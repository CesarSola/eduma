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
        $cursos = Curso::all(); // Asegúrate de que estás obteniendo todos los cursos en plural

        return view('lista_cursos.index', compact('usuario', 'cursos')); // Pasa la variable como 'cursos'
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'competencia' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'plataforma' => 'nullable|string|max:255',
            'costo' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
        ]);

        $curso = new Curso([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'competencia' => $request->input('competencia'),
            'instructor' => $request->input('instructor'),
            'duration' => $request->input('duration'),
            'modalidad' => $request->input('modalidad'),
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_final' => $request->input('fecha_final'),
            'plataforma' => $request->input('plataforma'),
            'costo' => $request->input('costo'),
            'certification' => $request->input('certification'),
        ]);

        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        return view('lista_cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'competencia' => 'nullable|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'duration' => 'nullable|integer',
            'modalidad' => 'nullable|string|max:255',
            'fecha_inicio' => 'nullable|date',
            'fecha_final' => 'nullable|date',
            'plataforma' => 'nullable|string|max:255',
            'costo' => 'nullable|string|max:255',
            'certification' => 'nullable|string|max:255',
        ]);

        $curso = Curso::findOrFail($id);
        $curso->update($request->all());

        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente');
    }

    // Otros métodos del controlador...
}
