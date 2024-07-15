<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estandares;
class ECviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $competencias =  Estandares::all();
        return view('ECviews',compact('competencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentosnec = DocumentosNec::all();
        return view('documentos.create', compact('documentosnec'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'documentosnec_id' => 'required|array',
        ]);

        $documento = Documentos::create([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        $documento->documentosnec()->attach($request->input('documentosnec_id'));

        return redirect()->route('documentos.index')->with('success', 'Documento creado exitosamente.');
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
