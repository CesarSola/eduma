<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Estandares;
use Illuminate\Support\Facades\Auth;

class CompetenciasController extends Controller
{

    public function index(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud o usar el usuario autenticado
        $userId = $request->query('user_id') ?? Auth::user()->id;

        // Obtener el ID del evaluador autenticado
        $evaluadorId = Auth::user()->id;

        // Buscar el usuario por ID
        $usuario = User::with('comprobantesCO', 'estandares')->findOrFail($userId);

        // Recuperar los comprobantes de competencia relacionados con el evaluador
        $comprobantesCO = $usuario->comprobantesCO()->where('evaluador_id', $evaluadorId)->get();

        // Obtener los IDs de los estándares asociados a estos comprobantes de competencia
        $estandaresIds = $comprobantesCO->pluck('estandar_id')->unique();

        // Obtener todos los estándares del usuario que están asociados con los comprobantes de competencia y el evaluador
        $competencias = $usuario->estandares()
            ->whereIn('id', $estandaresIds)
            ->with(['fechas' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }, 'fechas.horarios'])
            ->get();

        // Renderizar la vista del expediente de competencias del usuario
        return view('expedientes.expedientesAdmin.competencias.index', compact('usuario', 'competencias', 'userId'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lista_estandares.create');
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
