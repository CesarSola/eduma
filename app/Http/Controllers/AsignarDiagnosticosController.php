<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Diagnostico;

class AsignarDiagnosticosController extends Controller
{
    // Mostrar la vista de asignación de diagnósticos
    public function index()
    {
        $usuarios = User::all();
        $diagnosticos = Diagnostico::all(); // Obtén todos los diagnósticos

        // Obtener los estándares de todos los usuarios (si es necesario)
        $estandares = [];
        foreach ($usuarios as $usuario) {
            $estandares[$usuario->id] = $usuario->estandares()->get();
        }

        return view('Diagnosticos.asignar-diagnosticos', compact('usuarios', 'diagnosticos', 'estandares'));
    }

    // Guardar la asignación de diagnósticos
  // Guardar la asignación de diagnósticos
  public function guardarAsignacion(Request $request)
  {
      $request->validate([
          'user_id' => 'required|exists:users,id',
          'diagnostico_id' => 'required|exists:diagnosticos,id',
      ]);

      $user = User::find($request->input('user_id'));
      $diagnostico = diagnostico::find($request->input('diagnostico_id'));

      // Verifica si el usuario está inscrito en al menos un estándar
      if ($user->estandares()->count() === 0) {
          return redirect()->route('usuarios.asignar-diagnosticos')->with('error', 'El usuario no está inscrito en ningún estándar.');
      }

      // Verifica si el diagnóstico ya está asignado al usuario
      if ($user->diagnosticos()->where('diagnostico_id', $diagnostico->id)->exists()) {
          return redirect()->route('usuarios.asignar-diagnosticos')->with('error', 'El diagnóstico ya ha sido asignado a este usuario.');
      }

      // Asigna el diagnóstico al usuario
      $user->diagnosticos()->attach($diagnostico->id, [
          'user_name' => $user->name,
          'diagnostico_code' => $diagnostico->code,
      ]);

      return redirect()->route('usuarios.asignar-diagnosticos')->with('success', 'Diagnóstico asignado correctamente');
  }


    // Mostrar la vista de usuarios con diagnósticos asignados
    public function usuariosConDiagnosticos()
    {
        // Obtener todos los usuarios con sus diagnósticos asignados
        $usuarios = User::with('diagnosticos')->get();

        return view('Diagnosticos.usuarios-con-diagnosticos', compact('usuarios'));
    }
}
