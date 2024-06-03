<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\User;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud
        $userId = $request->query('user_id');

        // Verificar si se proporcionó un ID de usuario
        if ($userId) {
            // Buscar el usuario por ID
            $usuario = User::findOrFail($userId);
        } else {
            // Si no se proporciona un ID, obtener el usuario autenticado
            $usuario = auth()->user();
        }

        // Obtener todos los cursos
        $cursos = Curso::all();

        // Renderizar la vista de cursos del usuario con los cursos y el usuario
        return view('expedientes.expedientesAdmin.cursos.index', compact('usuario', 'cursos'));
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

        $cursos = new Curso([
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

        $cursos->save();

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cursos = Curso::findOrFail($id);
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

        $cursos = Curso::findOrFail($id);

        // Actualizar los datos del curso con los datos del formulario
        $cursos->update([
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
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado exitosamente');
    }

    // Otros métodos del controlador...
}
