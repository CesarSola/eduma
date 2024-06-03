<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentosUser;

class SDocumentosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('expedientes.expedientesUser.documentosUser.index');
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
        $user = Auth::user();
        $userName = str_replace(' ', '_', $user->name); // Reemplaza espacios en blanco con guiones bajos

        // Validar y almacenar la fotografía digital
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->storeAs('public/images/documentos/' . $userName, 'Foto.' . $foto->extension());
        }

        // Validar y almacenar la identificación oficial (INE o IFE)
        if ($request->hasFile('ine_ife')) {
            $ineIfe = $request->file('ine_ife');
            $ineIfePath = $ineIfe->storeAs('public/images/documentos/' . $userName, 'INE_o_IFE.' . $ineIfe->extension());
        }

        // Validar y almacenar el comprobante domiciliario
        if ($request->hasFile('comprobante_domiciliario')) {
            $comprobante = $request->file('comprobante_domiciliario');
            $comprobantePath = $comprobante->storeAs('public/images/documentos/' . $userName, 'Comprobante_Domicilio.' . $comprobante->extension());
        }

        // Validar y almacenar la CURP
        if ($request->hasFile('curp')) {
            $curp = $request->file('curp');
            $curpPath = $curp->storeAs('public/images/documentos/' . $userName, 'CURP.' . $curp->extension());
        }

        // Puedes guardar las rutas de los archivos en la base de datos
        $documentosUser = new DocumentosUser();
        $documentosUser->user_id = $user->id;
        $documentosUser->foto = $fotoPath ?? null;
        $documentosUser->ine_ife = $ineIfePath ?? null;
        $documentosUser->comprobante_domiciliario = $comprobantePath ?? null;
        $documentosUser->curp = $curpPath ?? null;
        $documentosUser->save();

        // Redireccionar o devolver una respuesta según sea necesario
        return redirect()->route('usuarios.index')->with('success', 'Documentos subidos correctamente');
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
