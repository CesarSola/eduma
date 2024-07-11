<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Estandares;
use Spatie\Permission\Models\Role;

class CompetenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud
        $userId = $request->query('user_id');

        // Buscar el usuario por ID, si no se proporciona ID, se obtiene el usuario autenticado
        $usuario = User::find($userId) ?? auth()->user();

        // Obtener todas las competencias asociadas al usuario
        $competencias = Estandares::with('comprobantesCO')->get();

        // Renderizar la vista del expediente de competencias del usuario
        return view('expedientes.expedientesAdmin.competencias.index', compact('usuario', 'competencias'));
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
        //
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
}
