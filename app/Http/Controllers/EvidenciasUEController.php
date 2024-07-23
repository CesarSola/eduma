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
use Illuminate\Support\Facades\Storage;

class EvidenciasUEController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id, $name)
    {
        $estandar = Estandares::find($id);
        $user_id = auth()->id();

        // Obtener evidencias
        $evidencias = DocumentosEvidencias::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->get();

        // Obtener ficha de registro y carta de firma
        $ficha_registro = FichasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        $carta_firma = CartasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        // Obtener validaciones para ficha y carta
        $fichas_validaciones = ValidacionesFichas::where('ficha_id', optional($ficha_registro)->id)
            ->with('fichas') // Cargar la relación de ficha
            ->get();

        $cartas_validaciones = ValidacionesCartas::where('carta_id', optional($carta_firma)->id)
            ->with('cartas') // Cargar la relación de carta
            ->get();

        // Obtener validaciones de documentos
        $validaciones_documentos = ValidacionesEvidencias::where('estandar_id', $id)
            ->get();
        // Consultar documentos necesarios
        $documentos_necesarios = DocumentosNec::whereHas('estandares', function ($query) use ($id) {
            $query->where('estandares.id', $id);
        })->get();

        // Determinar si las fichas y cartas han sido validadas
        $carta_validada = $cartas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();
        $ficha_validada = $fichas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();

        // Pasar datos a la vista
        return view('expedientes.expedientesUser.evidenciasEC.index', compact(
            'estandar',
            'evidencias',
            'ficha_registro',
            'carta_firma',
            'fichas_validaciones',
            'cartas_validaciones',
            'validaciones_documentos',
            'carta_validada',
            'ficha_validada',
            'documentos_necesarios'
        ));
    }

    public function download($id)
    {
        $documento = DocumentosNec::findOrFail($id);
        return Storage::download($documento->documento);
    }

    public function show($id, $documento_id)
    {
        $estandar = Estandares::find($id);
        $documento = DocumentosNec::find($documento_id);

        return view('expedientes.expedientesUser.evidenciasEC.show', compact('estandar', 'documento'));
    }
    public function upload(Request $request, $documento_id)
    {
        $request->validate([
            'documento' => 'required|file|mimes:pdf|max:2048',
        ]);

        $documento = DocumentosNec::find($documento_id);
        $user = auth()->user();
        $fileName = Str::slug($documento->name) . '.' . $request->file('documento')->getClientOriginalExtension(); // Create the new file name

        // Save the file in the specific directory
        $filePath = $request->file('documento')->storeAs(
            'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' . Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname),
            $fileName
        );

        // Save the file information to the database
        DocumentosEvidencias::create([
            'user_id' => auth()->id(),
            'estandar_id' => $documento->estandares->first()->id,
            'documento_id' => $documento_id,
            'file_path' => $filePath,
            'nombre' => $documento->name,  // Add this line to provide a value for the 'nombre' field
            'estado' => 'pendiente',       // If 'estado' field is also required, make sure to provide a value
        ]);

        return redirect()->route('evidenciasEC.index', ['id' => $documento->estandares->first()->id, 'name' => $documento->estandares->first()->name])
            ->with('success', 'Documento subido correctamente');
    }

    public function resubir(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $evidencia = DocumentosEvidencias::findOrFail($id);
        $documento = $evidencia->documento; // Obtener el documento relacionado
        $user = auth()->user();

        // Crear nombre de archivo
        $fileName = Str::slug($documento->name) . '.' . $request->file('file')->getClientOriginalExtension();

        // Crear ruta de almacenamiento
        $filePath = $request->file('file')->storeAs(
            'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' .  Str::slug($user->name . '  ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname),
            $fileName
        );

        // Elimina el archivo viejo si es necesario
        if (Storage::exists($evidencia->file_path)) {
            Storage::delete($evidencia->file_path);
        }

        // Actualiza el registro en la base de datos
        $evidencia->file_path = $filePath;
        $evidencia->nombre = $fileName; // Agrega este campo si es necesario
        $evidencia->estado = 'pendiente'; // Cambia el estado a 'pendiente'
        $evidencia->save();

        return redirect()->route('expedientes.expedientesUser.evidenciasEC.index')
            ->with('success', 'Documento resubido con éxito.');
    }
}
