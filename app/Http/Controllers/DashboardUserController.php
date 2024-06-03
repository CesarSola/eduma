<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\DocumentosUser;
use App\Models\Estandares;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // El usuario está autenticado, obtener el usuario autenticado
            $usuario = Auth::user();
        } else {
            // El usuario no está autenticado, redirigirlo a la página de inicio de sesión
            return redirect()->route('login');
        }

        // Obtener competencias y cursos
        $competencias = Estandares::all();
        $cursos = Curso::all();

        // Verificar si los documentos del usuario existen
        $documentos = DocumentosUser::where('user_id', $usuario->id)->exists();

        // Renderizar la vista con el usuario autenticado y otros datos
        return view('expedientes.expedientesUser.dashboardUser.index', compact('usuario', 'cursos', 'competencias', 'documentos'));
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
