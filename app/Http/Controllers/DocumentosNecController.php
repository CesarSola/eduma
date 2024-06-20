<?php

namespace App\Http\Controllers;

use App\Models\DocumentosNec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
            'documentos' => 'required|file|max:2048', // Asegúrate de que 'documentos' sea un archivo válido y requerido
        ]);

        // Crear una nueva competencia
        $documentosnec = DocumentosNec::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),


        ]);

    // Obtener el nombre limpio del documento (reemplazando espacios por guiones bajos)
    $documentosName = str_replace(' ', '_', $documentosnec->name);

    // Verificar y almacenar el documento si se ha enviado uno
    if ($request->hasFile('documentos')) {
        $documentos = $request->file('documentos');

        // Generar un nombre de archivo único basado en el timestamp y la extensión original
        $fileName = time() . '_' . $documentos->getClientOriginalName();

        // Almacenar el archivo en el disco 'public'
        $documentosPath = $documentos->storeAs('public/images/documentosnec/' . $documentosName, $fileName);

        // Registrar la ruta del documento para depuración
        Log::info('Documento almacenado en: ' . $documentosPath);

        // Verificar si el archivo fue almacenado correctamente
        if (Storage::exists($documentosPath)) {
            $documentosnec->documentos = str_replace('public/', 'storage/', $documentosPath);
        } else {
            Log::error('No se pudo almacenar el documento en: ' . $documentosPath);
        }
    }

    // Guardar la instancia de DocumentosNec en la base de datos
    $documentosnec->save();

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
            'documentos' => 'required|string|max:255',
        ]);

        // Buscar el curso por su ID
        $documentosnec= DocumentosNec::findOrFail($id);

        $documentosnec->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'documentos' => $request->input('documentos'),
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
