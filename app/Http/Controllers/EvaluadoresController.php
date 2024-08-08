<?php

namespace App\Http\Controllers;

use App\Models\EvaluadoresUsuarios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class EvaluadoresController extends Controller
{
    public function index()
    {
        $evaluadores = User::role('Evaluador')->get();
        return view('expedientes.expedientesAdmin.competencias.evaluadores.index', compact('evaluadores'));
    }

    public function create()
    {
        return view('expedientes.expedientesAdmin.competencias.evaluadores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'secondName' => 'nullable|string|max:255',
            'paternalSurname' => 'required|string|max:255',
            'maternalSurname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $request->name,
            'secondName' => $request->secondName,
            'paternalSurname' => $request->paternalSurname,
            'maternalSurname' => $request->maternalSurname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            // Dejar 'matricula' fuera para los evaluadores
        ]);

        // Asignar el rol de Evaluador
        $user->assignRole('Evaluador');

        return response()->json(['success' => 'Evaluador creado correctamente.']);
    }

    public function show($id)
    {
        // Obtener el evaluador con el ID especificado
        $evaluador = User::findOrFail($id);

        // Obtener los usuarios asignados a este evaluador
        $usuariosAsignados = EvaluadoresUsuarios::where('evaluador_id', $id)
            ->with('usuario')
            ->get()
            ->pluck('usuario');

        // Pasar datos a la vista, incluyendo el evaluador
        return view('expedientes.expedientesAdmin.competencias.evaluadores.show', compact('evaluador', 'usuariosAsignados'));
    }

    public function edit(User $evaluador)
    {
        return view('expedientes.expedientesAdmin.competencias.evaluadores.edit', compact('evaluador'));
    }

    public function update(Request $request, $id)
    {
        $evaluador = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'secondName' => 'nullable|string|max:255',
            'paternalSurname' => 'required|string|max:255',
            'maternalSurname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $evaluador->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'secondName', 'paternalSurname', 'maternalSurname', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $evaluador->update($data);

        return response()->json(['success' => 'Evaluador actualizado correctamente.']);
    }

    public function destroy($id)
    {
        try {
            // Encuentra el evaluador por ID y elimínalo
            $evaluador = User::findOrFail($id);
            $evaluador->delete();

            // Retorna una respuesta JSON de éxito
            return response()->json(['success' => 'Evaluador eliminado exitosamente.']);
        } catch (\Exception $e) {
            // Retorna una respuesta JSON de error en caso de excepción
            return response()->json(['error' => 'No se pudo eliminar el evaluador.'], 400);
        }
    }
}
