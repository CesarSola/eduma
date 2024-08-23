<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\EvaluadoresUsuarios as ModelsEvaluadoresUsuarios;
use Illuminate\Http\Request;
use App\Models\User;

class AsignarEvaController extends Controller
{
    public function index()
    {
        // Obtén todos los usuarios cuyo campo 'rol' es 'User' y carga sus estándares relacionados
        $users = User::where('rol', 'User')->with('estandares')->get();


        // Obtén la lista de evaluadores (usuarios con el rol "Evaluador")
        $evaluadores = User::role('Evaluador')->get();

        // Obtén las evaluaciones (suponiendo que tienes una relación definida para esto)
        $evaluaciones = ModelsEvaluadoresUsuarios::with('usuario', 'estandar', 'evaluador')->get();

        // Construye un arreglo para usuarios asignados a evaluadores
        $usuariosAsignados = $evaluaciones->groupBy('evaluador_id')->mapWithKeys(function ($evaluaciones, $evaluadorId) {
            return [$evaluadorId => $evaluaciones];
        });
        // Construye un arreglo para usuarios con evaluaciones agrupados por usuario
        $usuariosConEvaluaciones = $evaluaciones->groupBy('usuario_id');

        // Crear un array para verificar si un estándar ya tiene un evaluador asignado
        $evaluacionesPorUsuario = $evaluaciones->groupBy('usuario_id')->mapWithKeys(function ($evaluaciones, $usuarioId) {
            return [$usuarioId => $evaluaciones->pluck('estandar_id')->unique()->flip()->map(function () {
                return true;
            })];
        });

        // Retorna la vista con los datos
        return view('expedientes.expedientesAdmin.competencias.evaluadores.asignarEva.index', compact('users', 'evaluadores', 'evaluaciones', 'usuariosAsignados', 'evaluacionesPorUsuario', 'usuariosConEvaluaciones'));
    }

    public function store(Request $request)
    {
        // Validar los datos del request
        $validated = $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'estandar_id' => 'required|exists:estandares,id',
            'evaluador_id' => 'required|exists:users,id',
        ]);

        // Encontrar el usuario, el estándar y el evaluador
        $usuario = User::findOrFail($validated['usuario_id']);
        $estandar = Estandares::findOrFail($validated['estandar_id']);
        $evaluador = User::findOrFail($validated['evaluador_id']);

        // Asignar el evaluador al usuario y al estándar en la tabla evaluadores_usuarios
        ModelsEvaluadoresUsuarios::create([
            'usuario_id' => $usuario->id,
            'estandar_id' => $estandar->id,
            'evaluador_id' => $evaluador->id,
        ]);

        // Actualizar el evaluador_id en la tabla comprobantes_competencias
        $usuario->comprobantesCO()->where('estandar_id', $estandar->id)->update([
            'evaluador_id' => $evaluador->id,
        ]);

        return response()->json(['success' => true]);
    }
}
