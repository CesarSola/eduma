<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\DocumentosNec;
use App\Models\EvidenciasCompetencias;
use App\Models\EvidenciasCursos;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EvidenciasUCControlle extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $name)
    {
        $cursos = Curso::find($id);
        $documentos = $cursos->documentosnec;
        $evidencias = EvidenciasCursos::where('curso_id', $id)->where('user_id', auth()->id())->get();

        // Map document IDs to easily check if an evidence exists for a document
        $uploadedDocumentIds = $evidencias->pluck('documento_id')->toArray();

        return view('expedientes.expedientesUser.evidenciasCU.index', compact('cursos', 'documentos', 'evidencias', 'uploadedDocumentIds'));
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
    public function show($id, $documento_id)
    {
        $cursos = Curso::find($id);
        $documento = DocumentosNec::find($documento_id);

        return view('expedientes.expedientesUser.evidenciasCU.show', compact('cursos', 'documento'));
    }
    public function upload(Request $request, $documento_id)
    {
        $request->validate([
            'documento' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $documento = DocumentosNec::find($documento_id);
        $user = auth()->user();
        $userName = Str::slug($user->name);  // Convert the user's name to a URL-friendly format
        $fileName = Str::slug($documento->name) . '.' . $request->file('documento')->getClientOriginalExtension(); // Create the new file name

        // Save the file in the specific directory
        $filePath = $request->file('documento')->storeAs(
            'public/documents/evidence/curso' . $userName,
            $fileName
        );

        // Save the file information to the database
        EvidenciasCursos::create([
            'user_id' => auth()->id(),
            'curso_id' => $documento->cursos->first()->id,
            'documento_id' => $documento_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('evidenciasCU.index', ['id' => $documento->cursos->first()->id, 'name' => $documento->cursos->first()->name])
            ->with('success', 'Documento subido correctamente');
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
