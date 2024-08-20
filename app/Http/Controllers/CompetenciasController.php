<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Estandares;
use App\Models\FechaCompetencia;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CompetenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del usuario desde la solicitud o usar el usuario autenticado
        $userId = $request->query('user_id') ?? Auth::user()->id; // Usar Auth::user()->id

        // Buscar el usuario por ID
        $usuario = User::findOrFail($userId);

        // Obtener todas las competencias asociadas al usuario con sus fechas, horarios y comprobantesCO
        $competencias = $usuario->estandares()
            ->with(['fechas' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }, 'fechas.horarios', 'comprobantesCO'])
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
     * Store a newly created resource in storage.
     */
    public function agregarFechas($competenciaId, Request $request)
    {
        // Obtener la competencia por su ID
        $competencia = Estandares::findOrFail($competenciaId);

        // Obtener el userId desde la solicitud
        $userId = $request->query('user_id');

        // Verificar si se pasó un userId, si no, asignar el usuario autenticado
        $selectedUserId = $userId ?? Auth::user()->id; // Usar Auth::user()->id

        // Obtener el usuario para mostrar su nombre
        $usuario = User::findOrFail($selectedUserId);

        // Obtener las fechas del usuario seleccionado
        $fechasUsuario = $competencia->fechas->where('user_id', $selectedUserId);

        // Verificar si el usuario ya tiene fechas y horarios asignados
        $tieneFechasYHorarios = $fechasUsuario->isNotEmpty() && $fechasUsuario->every(function ($fecha) {
            return $fecha->horarios->isNotEmpty();
        });

        return view('expedientes.expedientesAdmin.competencias.agregar-fechas', compact('competencia', 'selectedUserId', 'fechasUsuario', 'usuario', 'tieneFechasYHorarios'));
    }


    public function guardarFechas(Request $request, $competenciaId)
    {
        // Validar la solicitud
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fechas.*' => 'required|date',
            'horarios.*.*' => 'required|date_format:H:i',
        ]);

        // Encontrar la competencia
        $competencia = Estandares::findOrFail($competenciaId);

        // Eliminar todas las fechas existentes para este usuario y competencia
        FechaCompetencia::where('competencia_id', $competenciaId)
            ->where('user_id', $request->user_id)
            ->delete();

        foreach ($request->fechas as $index => $fecha) {
            // Crear una nueva fecha asociada a la competencia
            $fechaCompetencia = new FechaCompetencia();
            $fechaCompetencia->fecha = $fecha;
            $fechaCompetencia->competencia_id = $competenciaId;
            $fechaCompetencia->user_id = $request->user_id; // Asigna el ID del usuario especificado
            $fechaCompetencia->save();

            // Guardar los horarios para esta fecha
            if (isset($request->horarios[$index])) {
                foreach ($request->horarios[$index] as $hora) {
                    try {
                        // Asegúrate de que la hora está en formato 'H:i'
                        $hora24 = Carbon::createFromFormat('H:i', $hora)->format('H:i');
                    } catch (\Exception $e) {
                        // Manejar el error de formato si ocurre
                        return back()->withErrors(['horarios' => 'Formato de hora inválido.']);
                    }

                    $horario = new Horario();
                    $horario->hora = $hora24; // Guarda el formato de 24 horas
                    $horario->competencia_id = $competenciaId;
                    $horario->fecha_competencia_id = $fechaCompetencia->id;
                    $horario->user_id = $request->user_id; // Asigna el ID del usuario especificado
                    $horario->save();
                }
            }
        }

        return Redirect::route('competencia.index')->with('success', 'Fechas y horarios agregados correctamente');
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
