<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CompetenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competencia = auth()->user();

        // Renderizar la vista del expediente del usuario
        return view('expedientes.expedientesAdmin.competencias.index', compact('competencia'));
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
        $competencia = User::findOrFail($id);

        // Renderizar la vista del expediente del usuario
        return view('expedientes.expedientesAdmin.competencia.show', compact('competencia'));
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
