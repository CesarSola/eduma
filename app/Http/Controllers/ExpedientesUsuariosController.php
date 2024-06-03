<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ExpedientesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuariosAdmin = User::with('documentos')->get();

        // Renderizar la vista con la lista de usuarios
        return view('expedientes.expedientesAdmin.usuarios.index', compact('usuariosAdmin'));
    }

    public function show($id)
    {
        $usuariosAdmin = User::with('documentos')->findOrFail($id);

        // Renderizar la vista del expediente del usuario
        return view('expedientes.expedientesAdmin.usuarios.show', compact('usuariosAdmin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mostrar el formulario de creación de un nuevo recurso

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Definir las reglas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'secondName' => 'required|string|max:255',
            'paternalSurname' => 'required|string|max:255',
            'maternalSurname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            // Otras reglas de validación si es necesario
        ];

        // Validar la solicitud
        $validatedData = $request->validate($rules);

        // Crear un nuevo usuario con los datos validados
        User::create($validatedData);

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuariosAdmin = User::findOrFail($id);

        return view('expedientes.expedientesAdmin.usuarios.edit', compact('usuariosAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Definir las reglas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'secondName' => 'required|string|max:255',
            'paternalSurname' => 'required|string|max:255',
            'maternalSurname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            // Otras reglas de validación si es necesario
        ];

        // Validar la solicitud
        $validatedData = $request->validate($rules);

        // Encontrar el usuario por ID
        $usuariosAdmin = User::findOrFail($id);

        // Actualizar el usuario con los datos validados
        $usuariosAdmin->update($validatedData);

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuariosAdmin = User::findOrFail($id);

        // Eliminar el usuario
        $usuariosAdmin->delete();

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
