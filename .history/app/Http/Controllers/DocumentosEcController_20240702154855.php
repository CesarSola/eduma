<?php

namespace App\Http\Controllers;

use App\Models\Documentos;
use App\Models\DocumentosNec;
use Illuminate\Http\Request;

class DocumentosEcController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documentos = Documentos::all();
        return view('lista_competencias.show', compact('documentos'));
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
        $documento = Documentos::findOrFail($id);
        $documentosnec = DocumentosNec::all();
        return view('documentos.edit', compact('documento', 'documentosnec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'numero' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'documentosnec_id' => 'required|array',
        ]);

        $documento = Documentos::findOrFail($id);
        $documento->update([
            'numero' => $request->input('numero'),
            'name' => $request->input('name'),
            'tipo' => $request->input('tipo'),
        ]);

        $documento->documentosnec()->sync($request->input('documentosnec_id'));

        return redirect()->route('documentos.index')->with('success', 'Documento actualizado exitosamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
