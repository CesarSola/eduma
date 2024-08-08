<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\EvaluadoresUsuarios as ModelsEvaluadoresUsuarios;
use Illuminate\Http\Request;
use App\Models\User;
use EvaluadoresUsuarios;

class AsignarEvaController extends Controller
{
    public function index()
    {
        $usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', 'User');
        })
            ->whereHas('comprobantesCO')
            ->whereDoesntHave('evaluaciones', function ($query) {
                $query->whereIn('estandar_id', Estandares::pluck('id'));
            })
            ->get();

        $evaluadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'Evaluador');
        })->get();

        $estandares = Estandares::whereDoesntHave('evaluaciones')->get();

        // Obtener evaluaciones con datos de usuario, estándar y evaluador
        $evaluaciones = ModelsEvaluadoresUsuarios::with(['usuario', 'estandar', 'evaluador'])->get();

        // Obtener usuarios asignados a cada evaluador
        $usuariosAsignados = [];
        foreach ($evaluadores as $evaluador) {
            $usuariosAsignados[$evaluador->id] = ModelsEvaluadoresUsuarios::where('evaluador_id', $evaluador->id)
                ->with(['usuario', 'estandar'])
                ->get();
        }

        return view('expedientes.expedientesAdmin.competencias.evaluadores.asignarEva.index', compact('usuarios', 'evaluadores', 'estandares', 'evaluaciones', 'usuariosAsignados'));
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

        // Asignar el evaluador al usuario y al estándar
        ModelsEvaluadoresUsuarios::create([
            'usuario_id' => $usuario->id,
            'estandar_id' => $estandar->id,
            'evaluador_id' => $evaluador->id,
        ]);

        return response()->json(['success' => true]);
    }
}
