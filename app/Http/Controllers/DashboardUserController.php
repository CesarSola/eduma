<?php

namespace App\Http\Controllers;

use App\Models\ComprobantePago;
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
        if (Auth::check()) {
            $usuario = Auth::user();
        } else {
            return redirect()->route('login');
        }

        $competencias = Estandares::all();
        $cursos = Curso::all();

        $documentos = DocumentosUser::where('user_id', $usuario->id)->exists();

        // Obtener los comprobantes de pago del usuario
        $comprobantes = ComprobantePago::where('user_id', $usuario->id)->get();

        return view('expedientes.expedientesUser.dashboardUser.index', compact('usuario', 'cursos', 'competencias', 'documentos', 'comprobantes'));
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
