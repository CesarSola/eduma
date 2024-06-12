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

        // Obtener todos los documentos del usuario con sus validaciones
        $documentos = DocumentosUser::where('user_id', $usuario->id)
            ->with('validacionesComentarios')
            ->get();

        // Obtener todos los comprobantes de pago del usuario con sus validaciones
        $comprobantes = ComprobantePago::where('user_id', $usuario->id)
            ->with('validacionesComentarios')
            ->get();

        // Filtrar los documentos que no están validados
        $documentosPendientes = $documentos->filter(function ($documento) {
            return $documento->validacionesComentarios->isEmpty() || !$documento->validacionesComentarios->last()->tipo_validacion;
        });

        // Filtrar los comprobantes que no están validados
        $comprobantesPendientes = $comprobantes->filter(function ($comprobante) {
            return $comprobante->validacionesComentarios->isEmpty() || !$comprobante->validacionesComentarios->last()->tipo_validacion;
        });

        $competencias = Estandares::all();
        $cursos = Curso::all();

        return view('expedientes.expedientesUser.dashboardUser.index', compact('usuario', 'cursos', 'competencias', 'documentos', 'documentosPendientes', 'comprobantesPendientes'));
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
