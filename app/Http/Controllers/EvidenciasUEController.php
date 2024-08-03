<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\DocumentosEvidencias;
use App\Models\DocumentosNec;
use App\Models\Estandares;
use App\Models\FechaElegida;
use App\Models\FichasDocumentos;
use App\Models\PlanesEvaluacion;
use App\Models\ValidacionesCartas;
use App\Models\ValidacionesEvidencias;
use App\Models\ValidacionesFichas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EvidenciasUEController extends Controller
{
    public function index($id, $name)
    {
        $estandar = Estandares::find($id);
        $user_id = auth()->id();

        // Obtener ficha de registro y carta de firma
        $ficha_registro = FichasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        $carta_firma = CartasDocumentos::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->first();

        // Obtener validaciones para ficha y carta
        $fichas_validaciones = ValidacionesFichas::where('ficha_id', optional($ficha_registro)->id)
            ->get();

        $cartas_validaciones = ValidacionesCartas::where('carta_id', optional($carta_firma)->id)
            ->get();

        // Consultar documentos necesarios
        $documentos_necesarios = DocumentosNec::whereHas('estandares', function ($query) use ($id) {
            $query->where('estandares.id', $id);
        })->get();

        // Determinar si las fichas y cartas han sido validadas
        $carta_validada = $cartas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();
        $ficha_validada = $fichas_validaciones->where('tipo_validacion', 'validar')->isNotEmpty();

        // Determinar si hay evidencias subidas y si todas están validadas
        $hay_evidencias_subidas = $documentos_necesarios->filter(function ($documento) use ($user_id, $id) {
            return $documento->isSubidoPorUsuario($user_id, $id);
        })->isNotEmpty();

        // Consulta para determinar si todas las evidencias están validadas
        $todos_documentos_validos = ValidacionesEvidencias::where('estandar_id', $id)
            ->where('user_id', $user_id)
            ->where('tipo_validacion', 'validar')
            ->count() === $documentos_necesarios->count();

        // Obtener las fechas elegidas por el usuario
        $fechas_elegidas = FechaElegida::join('fechas_competencias', 'fechas_horarios_elegidos.fecha_competencia_id', '=', 'fechas_competencias.id')
            ->join('horarios_competencias', 'fechas_horarios_elegidos.horario_competencia_id', '=', 'horarios_competencias.id')
            ->where('fechas_competencias.competencia_id', $id)
            ->where('fechas_horarios_elegidos.user_id', $user_id)
            ->select('fechas_horarios_elegidos.*', 'fechas_competencias.fecha', 'horarios_competencias.hora')
            ->get();

        // Pasar datos a la vista
        return view('expedientes.expedientesUser.evidenciasEC.index', compact(
            'estandar',
            'ficha_registro',
            'carta_firma',
            'fichas_validaciones',
            'cartas_validaciones',
            'carta_validada',
            'ficha_validada',
            'documentos_necesarios',
            'todos_documentos_validos',
            'hay_evidencias_subidas',
            'fechas_elegidas',
            'id' // Asegúrate de pasar esta variable a la vista
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
            'estandar_id' => 'required|exists:estandares,id', // Validar el estandar_id
        ]);

        $documento = DocumentosNec::find($documento_id);
        $estandarId = $request->input('estandar_id'); // Obtener el estandar_id desde la solicitud
        $estandar = Estandares::find($estandarId);

        if (!$documento || !$estandar) {
            return redirect()->back()->with('error', 'Documento o Estándar no encontrados.');
        }

        $user = auth()->user();
        $fileName = Str::slug($documento->name) . '.' . $request->file('documento')->getClientOriginalExtension();
        $filePath = $request->file('documento')->storeAs(
            'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' . Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname),
            $fileName
        );

        DocumentosEvidencias::create([
            'user_id' => auth()->id(),
            'estandar_id' => $estandarId, // Usar el estandar_id de la solicitud
            'documento_id' => $documento_id,
            'file_path' => $filePath,
            'nombre' => $documento->name,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('evidenciasEC.index', ['id' => $estandarId, 'name' => $estandar->name])
            ->with('success', 'Documento subido correctamente');
    }
}
