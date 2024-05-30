<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->user();

        // Renderizar la vista del expediente del usuario
        return view('expedientes.expedientesAdmin.registroGeneral.index', compact('usuario'));
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
        // Almacenar un nuevo recurso en el almacenamiento
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mostrar un recurso específico
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::find($id);

        return view('expedientes.expedientesAdmin.registroGeneral.edit', compact('usuario'));
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
        ];

        // Validar la solicitud
        $validatedData = $request->validate($rules);

        // Encontrar el usuario por ID
        $usuario = User::find($id);

        // Actualizar el usuario con los datos validados
        $usuario->update($validatedData);

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Eliminar un recurso específico del almacenamiento
    }
}
