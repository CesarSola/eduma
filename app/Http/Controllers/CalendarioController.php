<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\EvaluadoresUsuarios;
use App\Models\FechaCompetencia;
use App\Models\FechaElegida;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CalendarioController extends Controller
{

    public function index(Request $request)
    {
        // Obtén el ID del evaluador autenticado
        $evaluadorId = Auth::id();

        // Obtener todos los usuarios asignados a este evaluador
        $usuarios = User::whereHas('evaluaciones', function ($query) use ($evaluadorId) {
            $query->where('evaluador_id', $evaluadorId);
        })->with('estandares')->get();

        // Obtener todos los estándares
        $estandares = Estandares::all();

        // Supongamos que $competenciaId se pasa como parámetro en la solicitud
        $competenciaId = $request->query('competenciaId');

        // Obtener información de la competencia, si existe
        $competencia = null;
        if ($competenciaId) {
            $competencia = Estandares::find($competenciaId);
        }

        // Obtener fechas y horarios para cada usuario y estándar
        foreach ($usuarios as $usuario) {
            foreach ($usuario->estandares as $estandar) {
                $estandar->fechas = FechaCompetencia::where('user_id', $usuario->id)
                    ->where('competencia_id', $estandar->id)
                    ->get();
                foreach ($estandar->fechas as $fecha) {
                    $fecha->horarios = Horario::where('fecha_competencia_id', $fecha->id)->get();
                }
            }
        }

        // Retornar la vista con los datos necesarios
        return view('expedientes.expedientesAdmin.competencias.fechas.index', [
            'usuarios' => $usuarios,
            'competencia' => $competencia,
            'estandares' => $estandares,
            'selectedUserId' => $request->query('user_id', null),
            'competenciaId' => $competenciaId, // Asegúrate de pasar esta variable
        ]);
    }

    public function show($competenciaId, Request $request)
    {
        $evaluadorId = Auth::id();

        // Obtener la competencia por ID utilizando el modelo Estandares.
        $competencia = Estandares::findOrFail($competenciaId);

        // Obtener todos los usuarios asignados al evaluador autenticado y cargar sus estándares
        $usuarios = User::whereHas('evaluaciones', function ($query) use ($evaluadorId) {
            $query->where('evaluador_id', $evaluadorId);
        })->with('estandares')->get();

        // Obtener fechas y horarios disponibles para los usuarios del evaluador
        $fechasDisponibles = FechaCompetencia::whereIn('user_id', $usuarios->pluck('id'))
            ->with('competencia', 'horarios', 'user')
            ->get();

        // Obtener fechas y horarios elegidos por los usuarios del evaluador
        $fechasElegidas = FechaElegida::whereIn('user_id', $usuarios->pluck('id'))
            ->with('fechaCompetencia', 'horarioCompetencia', 'user')
            ->get();

        // Obtener el user_id de la solicitud, si se proporciona.
        $selectedUserId = $request->input('user_id', null);

        // Retornar la vista con los datos necesarios.
        return view('expedientes.expedientesAdmin.competencias.fechas.show', [
            'competencia' => $competencia,
            'fechasDisponibles' => $fechasDisponibles,
            'fechasElegidas' => $fechasElegidas,
            'selectedUserId' => $selectedUserId,
        ]);
    }


    public function getUsuariosSinRolAdmin()
    {
        $adminRole = Role::where('name', 'admin')->first();

        // Obtener solo los usuarios que no tienen el rol de administrador
        return User::whereDoesntHave('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->with('documentos')->get(); // No es necesario el with aquí
    }
}
