<?php

namespace App\Http\Controllers;

use App\Models\DocumentosNec;
use Illuminate\Http\Request;

class DocumentosNecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $documentosnec = DocumentosNec::all();


        return view('Documentos_necesarios.index', compact('documentosnec'));
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

            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Crear una nueva competencia
        DocumentosNec::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),


        ]);

        // Redirigir a la misma página con un mensaje de éxito
        return back()->with('success', 'Competencia creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentosNec $documentosNec)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentosNec $documentosNec)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $request->validate([

            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Buscar el curso por su ID
        $documentosnec= DocumentosNec::findOrFail($id);

        $documentosnec->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return back()->with('success', 'actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentosNec $documentosNec)
    {
        //
    }
}
