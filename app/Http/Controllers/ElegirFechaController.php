<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FechaCompetencia;
use App\Models\FechaElegida;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ElegirFechaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el ID del estándar desde la solicitud
        $estandarId = $request->query('estandar_id');

        // Obtener el ID del usuario desde la solicitud o usar el usuario autenticado
        $userId = $request->query('user_id') ?? auth()->user()->id;

        // Buscar el estándar por ID
        $estandar = Estandares::find($estandarId);

        if (!$estandar) {
            return redirect()->route('miscompetencias.index')->with('error', 'El estándar no fue encontrado.');
        }

        // Buscar el usuario por ID
        $usuario = User::findOrFail($userId);

        // Obtener las fechas y horarios asociados al estándar para el usuario específico
        $fechas_competencia = $estandar->fechas()->with(['horarios' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->where('user_id', $userId)->get();

        // Renderizar la vista con los datos
        return view('expedientes.expedientesUser.evidenciasEC.fechas.index', [
            'fechas_competencia' => $fechas_competencia,
            'estandar' => $estandar,
            'usuario' => $usuario
        ]);
    }

    public function show($id, Request $request)
    {
        // Obtener el ID del usuario desde la solicitud o usar el usuario autenticado
        $userId = $request->query('user_id') ?? auth()->user()->id;

        // Buscar el estándar por ID
        $estandar = Estandares::findOrFail($id);

        // Buscar el usuario por ID
        $usuario = User::findOrFail($userId);

        // Obtener las fechas y horarios asociados al estándar para el usuario específico
        $fechas_competencia = $estandar->fechas()->with(['horarios' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->where('user_id', $userId)->get();

        // Depuración para verificar los datos obtenidos
        if ($fechas_competencia->isEmpty()) {
            dd("No se encontraron fechas para el estándar con ID $id y usuario con ID $userId", $estandar, $fechas_competencia);
        }

        // Renderizar la vista con los datos
        return view('expedientes.expedientesUser.evidenciasEC.fechas.show', [
            'estandar' => $estandar,
            'fechas_competencia' => $fechas_competencia,
            'usuario' => $usuario
        ]);
    }

    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'fecha_competencia_id' => 'required|exists:fechas_competencias,id',
            'horario_id' => 'required|exists:horarios_competencias,id',
        ]);

        // Guardar la fecha y horario elegidos
        FechaElegida::create([
            'user_id' => auth()->id(),
            'fecha_competencia_id' => $request->input('fecha_competencia_id'),
            'horario_competencia_id' => $request->input('horario_id'),
        ]);

        // Obtener el competencia_id de la fecha_competencia para la redirección
        $fechaCompetencia = FechaCompetencia::find($request->input('fecha_competencia_id'));
        $competenciaId = $fechaCompetencia->competencia_id;

        // Obtener el objeto Competencia
        $competencia = Estandares::find($competenciaId);

        if (!$competencia) {
            return redirect()->route('miscompetencias.index')->with('error', 'La competencia no fue encontrada.');
        }

        return redirect()->route('evidenciasEC.index', ['id' => $competenciaId, 'name' => $competencia->name])
            ->with('success', 'Fecha y horario guardados con éxito.');
    }
}
