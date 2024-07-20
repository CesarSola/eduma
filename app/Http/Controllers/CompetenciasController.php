<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Estandares;
use App\Models\FechaCompetencia;
use Illuminate\Support\Facades\Redirect;

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

        // Obtener todas las competencias asociadas al usuario con sus fechas y comprobantesCO
        $competencias = $usuario->estandares()->with(['fechas', 'comprobantesCO'])->get();

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
    public function agregarFechas($competenciaId)
    {
        // Aquí puedes obtener la competencia por su ID y pasarla a la vista
        $competencia = Estandares::findOrFail($competenciaId);
        return view('expedientes.expedientesAdmin.competencias.agregar-fechas', compact('competencia'));
    }

    public function guardarFechas(Request $request, $competenciaId)
    {
        // Valida y guarda las fechas para la competencia
        $request->validate([
            'fechas.*' => 'required|date',
        ]);

        $competencia = Estandares::findOrFail($competenciaId);

        // Eliminar todas las fechas existentes para esta competencia
        $competencia->fechas()->delete();

        foreach ($request->fechas as $fecha) {
            // Crea una nueva fecha asociada a la competencia
            $fechaCompetencia = new FechaCompetencia();
            $fechaCompetencia->fecha = $fecha;

            // Guarda la fecha asociada a la competencia
            $competencia->fechas()->save($fechaCompetencia);
        }
        return Redirect::route('competencia.index')->with('success', 'Fechas agregadas correctamente');
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
