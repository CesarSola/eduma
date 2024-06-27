<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso; // Asegúrate de importar el modelo Curso aquí
use Illuminate\Http\Request;

class MisCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = User::findOrFail(auth()->user()->id);
        $cursos = $usuario->cursos; // Accede a la relación de cursos

        return view('expedientes.expedientesUser.miscursos.index', compact('cursos', 'usuario'));
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
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
