<?php

namespace App\Http\Controllers;

use App\Models\User; // Cambiar a User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role; // Asegúrate de importar el modelo Role

class EvaluadoresController extends Controller
{
    public function index()
    {
        $evaluadores = User::role('Evaluador')->get(); // Obtener solo los usuarios con el rol 'Evaluador'
        return view('expedientes.expedientesAdmin.competencias.evaluadores.index', compact('evaluadores'));
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

        $user = User::create([
            'name' => $request->name,
            'secondName' => $request->secondName,
            'paternalSurname' => $request->paternalSurname,
            'maternalSurname' => $request->maternalSurname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'Evaluador',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10), // Genera un token aleatorio
        ]);


        $user->assignRole('Evaluador');

        return redirect()->route('evaluadores.index')->with('success', 'Evaluador creado exitosamente.');
    }

    public function show(User $evaluador)
    {
        return view('evaluadores.show', compact('evaluador'));
    }

    public function edit(User $evaluador)
    {
        return view('evaluadores.edit', compact('evaluador'));
    }

    public function update(Request $request, $id)
    {
        $evaluador = User::findOrFail($id);

        $evaluador->update([
            'name' => $request->input('name'),
            'secondName' => $request->input('secondName'),
            'paternalSurname' => $request->input('paternalSurname'),
            'maternalSurname' => $request->input('maternalSurname'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('evaluadores.index')->with('success', 'Evaluador actualizado correctamente.');
    }

    public function destroy($id)
    {
        $evaluador = User::findOrFail($id);
        $evaluador->delete();

        return redirect()->route('evaluadores.index')->with('success', 'Evaluador eliminado exitosamente.');
    }
}
