<?php

namespace App\Http\Controllers;

use App\Models\DocumentosNec;
use App\Models\Estandares;
use App\Models\EvidenciasCompetencias;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class EvidenciasUEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $name)
    {
        $estandar = Estandares::find($id);
        $documentos = $estandar->documentosnec;
        $evidencias = EvidenciasCompetencias::where('estandar_id', $id)->where('user_id', auth()->id())->get();

        // Verificar si existen los documentos específicos en las columnas correspondientes
        $ficha_registro = EvidenciasCompetencias::where('estandar_id', $id)
            ->where('user_id', auth()->id())
            ->whereNotNull('ficha_registro_path')
            ->exists();

        $carta_firma = EvidenciasCompetencias::where('estandar_id', $id)
            ->where('user_id', auth()->id())
            ->whereNotNull('carta_firma_path')
            ->exists();

        // Map document IDs to easily check if an evidence exists for a document
        $uploadedDocumentIds = $evidencias->pluck('documento_id')->toArray();

        return view('expedientes.expedientesUser.evidenciasEC.index', compact('estandar', 'documentos', 'evidencias', 'ficha_registro', 'carta_firma', 'uploadedDocumentIds'));
    }

    public function show($id, $documento_id)
    {
        $estandar = Estandares::find($id);
        $documento = DocumentosNec::find($documento_id);

        return view('expedientes.expedientesUser.evidenciasEC.show', compact('estandar', 'documento'));
    }

    /**
     * Handle the document upload.
     */
    public function upload(Request $request, $documento_id)
    {
        $request->validate([
            'documento' => 'required|file|mimes:pdf|max:2048',
        ]);

        $documento = DocumentosNec::find($documento_id);
        $user = auth()->user();
        $userName = Str::slug($user->name);  // Convert the user's name to a URL-friendly format
        $fileName = Str::slug($documento->name) . '.' . $request->file('documento')->getClientOriginalExtension(); // Create the new file name

        // Save the file in the specific directory
        $filePath = $request->file('documento')->storeAs(
            'public/documents/evidence/competencias' . $userName,
            $fileName
        );

        // Save the file information to the database
        EvidenciasCompetencias::create([
            'user_id' => auth()->id(),
            'estandar_id' => $documento->estandares->first()->id,
            'documento_id' => $documento_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('evidenciasEC.index', ['id' => $documento->estandares->first()->id, 'name' => $documento->estandares->first()->name])
            ->with('success', 'Documento subido correctamente');
    }
}
