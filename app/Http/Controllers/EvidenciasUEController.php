<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\DocumentosEvidencias;
use App\Models\DocumentosNec;
use App\Models\Estandares;
use App\Models\FichasDocumentos;
use App\Models\ValidacionesCartas;
use App\Models\ValidacionesEvidencias;
use App\Models\ValidacionesFichas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvidenciasUEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $name)
    {
        $estandar = Estandares::find($id);
        $user_id = auth()->id();

        $evidencias = DocumentosEvidencias::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->get();

        $ficha_registro = FichasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        // Verifica el contenido de estado en CartasDocumentos
        $carta_firma = CartasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        // Verifica si hay registros en validaciones_fichas
        $fichas_validaciones = ValidacionesFichas::where('estandar_id', $id)
            ->whereIn('ficha_id', $evidencias->pluck('ficha_id')->filter())
            ->get();

        // Verifica si hay registros en validaciones_cartas
        $cartas_validaciones = ValidacionesCartas::where('estandar_id', $id)
            ->whereIn('carta_id', $evidencias->pluck('carta_id')->filter())
            ->get();

        // Verifica si se está filtrando correctamente
        $carta_validada = $cartas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();
        $ficha_validada = $fichas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();


        return view('expedientes.expedientesUser.evidenciasEC.index', compact(
            'estandar',
            'evidencias',
            'ficha_registro',
            'carta_firma',
            'fichas_validaciones',
            'cartas_validaciones',
            'carta_validada',
            'ficha_validada'
        ));
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
            'public/documents/evidence/competencias/' . $userName,
            $fileName
        );

        // Save the file information to the database
        DocumentosEvidencias::create([
            'user_id' => auth()->id(),
            'estandar_id' => $documento->estandares->first()->id,
            'documento_id' => $documento_id,
            'file_path' => $filePath,
        ]);

        return redirect()->route('evidenciasEC.index', ['id' => $documento->estandares->first()->id, 'name' => $documento->estandares->first()->name])
            ->with('success', 'Documento subido correctamente');
    }
}
