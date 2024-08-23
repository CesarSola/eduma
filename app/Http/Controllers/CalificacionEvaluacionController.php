<?php

namespace App\Http\Controllers;

use App\Models\CalificacionEvaluacion;
use App\Models\Estandares;
use App\Models\User;
use Illuminate\Http\Request;

class CalificacionEvaluacionController extends Controller
{
    public function show()
    {
        $users = User::where('role', 'User')->get();
        $estandares = Estandares::all();

        return view('expedientes.expedientesAdmin.competencias.calificacion.show', compact('users', 'estandares'));
    }

    public function showCalificaciones($userId, $estandarId)
    {
        // Obtener la calificación asignada para el usuario y el estándar específicos
        $calificaciones = CalificacionEvaluacion::where('user_id', $userId)
            ->where('estandar_id', $estandarId)
            ->get();

        // Obtener el usuario y el estándar
        $usuario = User::findOrFail($userId);
        $estandar = Estandares::findOrFail($estandarId);

        // Retornar la vista con las calificaciones
        return view('expedientes.expedientesAdmin.competencias.fechas.verCalificaciones.show', [
            'usuario' => $usuario,
            'estandar' => $estandar,
            'calificaciones' => $calificaciones
        ]);
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'estandar_id' => 'required|exists:estandares,id',
            'evaluator_id' => 'required|exists:users,id',
            'evidencias' => 'required|numeric|min:0|max:100',
            'evaluacion' => 'required|numeric|min:0|max:100',
            'presentacion' => 'required|numeric|min:0|max:100',
        ]);

        // Obtener el nombre completo del usuario
        $usuario = User::findOrFail($request->user_id);
        $nombreUsuario = collect([
            $usuario->name,
            $usuario->secondName,
            $usuario->paternalSurname,
            $usuario->maternalSurname
        ])->filter()->join(' ');

        // Guardar la calificación en la base de datos
        CalificacionEvaluacion::create([
            'evaluador_id' => $request->evaluator_id,
            'user_id' => $request->user_id,
            'nombre_usuario' => $nombreUsuario,
            'matricula' => $usuario->matricula,
            'estandar_id' => $request->estandar_id,
            'evidencias' => $request->evidencias,
            'evaluacion' => $request->evaluacion,
            'presentacion' => $request->presentacion,
        ]);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('calificaciones.store')->with('success', 'Calificación asignada correctamente.');
    }
}
