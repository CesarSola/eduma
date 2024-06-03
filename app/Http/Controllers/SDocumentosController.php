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
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,bmp|max:300',
            'ine_ife' => 'required|mimes:pdf|max:1024',
            'comprobante_domiciliario' => 'required|mimes:pdf|max:1024',
            'curp' => 'required|mimes:pdf|max:1024',
        ]);

        $user = Auth::user();
        $folderPath = 'documentos/' . $user->id;

        // Almacenar los archivos y obtener sus rutas
        $fotoPath = $request->file('foto')->storeAs($folderPath, 'Foto.' . $request->file('foto')->extension(), 'public');
        $ineIfePath = $request->file('ine_ife')->storeAs($folderPath, 'INE_o_IFE.' . $request->file('ine_ife')->extension(), 'public');
        $comprobanteDomiciliarioPath = $request->file('comprobante_domiciliario')->storeAs($folderPath, 'Comprobante_Domicilio.' . $request->file('comprobante_domiciliario')->extension(), 'public');
        $curpPath = $request->file('curp')->storeAs($folderPath, 'CURP.' . $request->file('curp')->extension(), 'public');

        // Guardar las rutas de los archivos en la base de datos
        DocumentosUser::create([
            'user_id' => $user->id,
            'foto' => $fotoPath,
            'ine_ife' => $ineIfePath,
            'comprobante_domiciliario' => $comprobanteDomiciliarioPath,
            'curp' => $curpPath,
        ]);

        return redirect()->route('documentosUser.index')->with('success', 'Documentos subidos correctamente.');
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
