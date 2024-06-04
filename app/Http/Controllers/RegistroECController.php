<?php

namespace App\Http\Controllers;

use App\Models\DocumentosUser;
use App\Models\Estandares;
use Illuminate\Http\Request;

class RegistroECController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener los estándares de competencia
        $EC = Estandares::all();

        // Pasar los datos a la vista
        return view('expedientes.expedientesUser.registroEC.index', compact('EC'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function storeDocumentosIns(Request $request)
    {
        $request->validate([
            'ficha_inscripcion' => 'required|mimes:doc,docx|max:2048',
        ]);

        $path = $request->file('ficha_inscripcion')->store('public/documentos');

        $documentosUser = DocumentosUser::where('user_id', auth()->id())->first();
        if (!$documentosUser) {
            $documentosUser = new DocumentosUser();
            $documentosUser->user_id = auth()->id();
        }
        $documentosUser->ficha_inscripcion = $path;
        $documentosUser->save();

        return redirect()->route('documentosIns.create')->with('success', 'Ficha de inscripción subida correctamente');
    }

    public function storeDocumentosComp(Request $request)
    {
        $request->validate([
            'comprobante_pago' => 'required|image|max:2048',
        ]);

        $path = $request->file('comprobante_pago')->store('public/documentos');

        $documentosUser = DocumentosUser::where('user_id', auth()->id())->first();
        if (!$documentosUser) {
            $documentosUser = new DocumentosUser();
            $documentosUser->user_id = auth()->id();
        }
        $documentosUser->comprobante_pago = $path;
        $documentosUser->save();

        return redirect()->route('documentosComp.create')->with('success', 'Comprobante de pago subido correctamente');
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
