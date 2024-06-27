<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class RegistroCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::all(); // Obtén todas las competencias disponibles
        return view('expedientes.expedientesUser.registroCursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $curso = Curso::findOrFail($competenciaEC);
        $user = Auth::user();
        $comprobanteExistente = ComprobantePago::where('user_id', $user->id)
            ->where('estandar_id', $competenciaEC)
            ->first();

        return view('expedientes.expedientesUser.registroEC.show', compact('competencia', 'comprobanteExistente'));
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
    public function show(string $id)
    {
        //
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
