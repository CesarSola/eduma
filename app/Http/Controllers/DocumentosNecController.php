<?php

namespace App\Http\Controllers;

use App\Models\DocumentosNec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        return view('Documentos_necesarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'documento' => 'required|file|mimes:pdf|max:2048', // Validación para el campo 'documento'
        ]);
    
        try {
            $user = Auth::user();
            $userName = str_replace(' ', '_', $user->name);
            $userSecondName = str_replace(' ', '_', $user->secondName);
            $documentName = str_replace(' ', '_', $request->input('name'));
    
            if ($request->hasFile('documento')) {
                $file = $request->file('documento');
                $filePath = $file->storeAs('public/documents/required/required documents/' . $userName . ' ' . $userSecondName, $documentName . '.' . $file->getClientOriginalExtension());
                
                Log::info('Archivo guardado en: ' . $filePath);
    
                $documento = DocumentosNec::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'documento' => $filePath,
                ]);
    
                session()->flash('success', 'Documento creado exitosamente');
                return back();
            } else {
                throw new \Exception('No se ha proporcionado un archivo válido');
            }
        } catch (\Exception $e) {
            Log::error('Error al crear documento:', ['exception' => $e]);
            session()->flash('error', 'Hubo un problema al intentar crear el documento.');
            return back();
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(DocumentosNec $documentosNec)
    {
        return view('Documentos_necesarios.show', compact('documentosNec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentosNec $documentosNec)
    {
        return view('Documentos_necesarios.edit', compact('documentosNec'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'documento' => 'file|mimes:pdf|max:2048', // Permitir la actualización opcional del documento
        ]);

        try {
            $documentosnec = DocumentosNec::findOrFail($id);

            // Guardar el archivo en la misma carpeta si se proporciona uno nuevo
            if ($request->hasFile('documento')) {
                $user = Auth::user();
                $userName = str_replace(' ', '_', $user->name);
                $userSecondName = str_replace(' ', '_', $user->secondName);
                $documentName = str_replace(' ', '_', $request->input('name'));

                $file = $request->file('documento');
                $filePath = $file->storeAs('public/documents/required/required documents/' . $userName . ' ' . $userSecondName, $documentName . '.' . $file->getClientOriginalExtension());
                $documentosnec->documento = $filePath; // Actualizamos la ruta del archivo en el campo 'documento'
            }

            // Actualizar los datos del documento
            $documentosnec->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            return back()->with('success', 'Documento actualizado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar documento:', ['exception' => $e]);
            return back()->withErrors(['error' => 'Hubo un problema al intentar actualizar el documento.']);
        }
    }
    public function download($id)
    {
        $documento = DocumentosNec::findOrFail($id);
        $filePath = $documento->documento;

        if (Storage::exists($filePath)) {
            return Storage::download($filePath);
        }

        return redirect()->back()->with('error', 'Archivo no encontrado.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentosNec $documentosNec)
    {
        $documentosNec->delete();
        return back()->with('success', 'Documento eliminado exitosamente');
    }
}
