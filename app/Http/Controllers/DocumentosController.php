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
        $registroGeneral = User::first();

        // Render the view with the user data
        return view('expedientes.expedientesAdmin.registroGeneral.index', compact('registroGeneral'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Obtener los datos del usuario con el ID dado
        $user = User::findOrFail($id);

        // Pasar los datos del usuario a la vista
        return view('expedientes.expedientesAdmin.registroGeneral.index', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
