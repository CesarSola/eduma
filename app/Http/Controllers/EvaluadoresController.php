<?php

namespace App\Http\Controllers;

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
    
        return redirect()->route('evaluadores.index')->with('success', 'Evaluador creado exitosamente.');
    }
    
    public function show(User $evaluador)
    {
        return view('expedientes.expedientesAdmin.competencias.evaluadores.show', compact('evaluador'));
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

        return redirect()->route('evaluadores.index')->with('success', 'Evaluador actualizado correctamente.');
    }

    public function destroy($id)
    {
        $evaluador = User::findOrFail($id);
        $evaluador->delete();

        return redirect()->route('evaluadores.index')->with('success', 'Evaluador eliminado exitosamente.');
    }
}
