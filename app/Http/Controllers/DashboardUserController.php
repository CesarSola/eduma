<?php

namespace App\Http\Controllers;

use App\Models\ComprobantePago;
use App\Models\Curso;
use App\Models\DocumentosUser;
use App\Models\Estandares;
use Illuminate\Database\Eloquent\Collection;
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

        // Obtener los documentos del usuario
        $documentos = DocumentosUser::where('user_id', $usuario->id)->with(['validacionesComentarios' => function ($query) {
            $query->latest();
        }])->get();

        // Obtener los comprobantes de pago del usuario
        $comprobantes = ComprobantePago::where('user_id', $usuario->id)->with(['validacionesComentarios' => function ($query) {
            $query->latest();
        }])->get();
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
