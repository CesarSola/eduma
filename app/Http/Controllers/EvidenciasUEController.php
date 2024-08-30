<?php

namespace App\Http\Controllers;

use App\Models\CalificacionEvaluacion;
use App\Models\CartasDocumentos;
use App\Models\CedulaEvaluacion;
use App\Models\ComprobanteCertificacion;
use App\Models\DocumentosEvidencias;
use App\Models\DocumentosNec;
use App\Models\Estandares;
use App\Models\EvaluadoresUsuarios;
use App\Models\FechaElegida;
use App\Models\FichasDocumentos;
use App\Models\JuiciosUsuario;
use App\Models\PlanesEvaluacion;
use App\Models\ValidacionesCartas;
use App\Models\ValidacionesCertificaciones;
use App\Models\ValidacionesEvidencias;
use App\Models\ValidacionesFichas;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EvidenciasUEController extends Controller
{
    public function index($id, $name)
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirige a la página de inicio de sesión
        }
        $estandar = Estandares::find($id);
        $user_id = Auth::id();

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
            ->get()
            ->map(function ($fecha) {
                try {
                    // Convertir el formato 'HH:MM:SS' a 'h:i A' (12 horas con AM/PM)
                    $hora24 = $fecha->hora; // Suponiendo que el formato es 'HH:MM:SS'
                    $fecha->horaFormatted = Carbon::createFromFormat('H:i:s', $hora24)->format('g:i A');
                } catch (\Exception $e) {
                    // Manejar excepciones, por ejemplo, para depuración
                    $fecha->horaFormatted = 'Formato no válido';
                }
                return $fecha;
            });

        // Obtener el evaluador relacionado con el estándar y el usuario
        $evaluador = EvaluadoresUsuarios::where('usuario_id', $user_id)
            ->where('estandar_id', $id)
            ->with('evaluador') // Asegúrate de incluir la relación evaluador
            ->first();

        // Consultar si ya se ha subido una cedula de evaluación
        $cedula_evaluacion_subido = CedulaEvaluacion::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->exists();

        // Consultar si ya se ha subido un plan de evaluación
        $plan_evaluacion_subido = PlanesEvaluacion::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->exists();

        // Consultar si ya se ha subido un juicio de competencia
        $juicio_competencia_subido = JuiciosUsuario::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->exists();

        // Obtener las calificaciones del usuario
        $calificaciones = CalificacionEvaluacion::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->first();

        if ($calificaciones) {
            // Calcular el promedio
            $evidencias = $calificaciones->evidencias ?? 0;
            $evaluacion = $calificaciones->evaluacion ?? 0;
            $presentacion = $calificaciones->presentacion ?? 0;

            $promedio = ($evidencias + $evaluacion + $presentacion) / 3;

            // Convertir el promedio a un porcentaje
            $promedio = $promedio * 10; // Porque estamos en una escala de 1 a 10
        } else {
            $promedio = 0;
        }

        // Obtener la calificación mínima del estándar
        $calificacion_minima = $estandar->calificacion_minima;

        // Consultar si ya se ha subido un comprobante de pago
        $comprobante_pago_subido = ComprobanteCertificacion::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->whereNotNull('comprobante_pago') // Ajusta esto según la columna que almacena el archivo de pago
            ->exists();
        // Consultar el estado del comprobante de pago
        $comprobante = ComprobanteCertificacion::where('user_id', $user_id)
            ->where('estandar_id', $id)
            ->first();

        $estado_comprobante = $comprobante ? json_decode($comprobante->estado, true) : null;

        // Determinar si el comprobante está en estado "validar"
        $estado_comprobante_valido = $estado_comprobante && $estado_comprobante['comprobante'] === 'validar';

        // Determinar si el comprobante está en estado "rechazar"
        $estado_comprobante_rechazado = $estado_comprobante && $estado_comprobante['comprobante'] === 'rechazar';

        // Determinar si el comprobante está en proceso de validación
        $comprobante_en_proceso = $comprobante_pago_subido === null  && $estado_comprobante['comprobante'] === 'pendiente';


        // Pasar datos a la vista
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
            'evaluador',
            'plan_evaluacion_subido',
            'cedula_evaluacion_subido',
            'juicio_competencia_subido',
            'estado_comprobante',
            'comprobante_pago_subido', // Agrega esto
            'comprobante',
            'estado_comprobante_valido',
            'estado_comprobante_rechazado',
            'comprobante_en_proceso',
            'id',
            'promedio',
            'calificacion_minima'
        ));
    }

    /**
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
    public function mostrarRechazado($id)
    {
        $competencia = Estandares::findOrFail($id);
        $validacionComentario = ValidacionesCertificaciones::where('comprobante_id', $competencia->id)
            ->where('comprobante_id', 'tipo_validacion')
            ->first();

        // Obtener las validaciones de comprobantes para las competencias del usuario
        $validacionesComentarios = ValidacionesCertificaciones::whereIn('comprobante_id', $competencia->pluck('id'))
            ->where('tipo_documento', 'comprobante')
            ->with('usuario')
            ->get()
            ->keyBy('comprobante_id');

        // Pasar los datos a la vista correspondiente
        return view('expedientes.expedientesUser.evidenciasEC.index', compact('competencias', 'validacionesComentarios'));
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

        // Asegúrate de que 'documentos_necesarios' también esté disponible si lo usas en la vista
        $documentos_necesarios = DocumentosNec::all(); // O ajusta esta línea según tu lógica

        return view('expedientes.expedientesUser.evidenciasEC.show', compact('estandar', 'documento', 'documentos_necesarios'));
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
            return response()->json(['success' => false, 'message' => 'Documento o Estándar no encontrados.']);
        }

        $user = Auth::user();
        $fileName = Str::slug($documento->name) . '.' . $request->file('documento')->getClientOriginalExtension();
        // Aquí se incluye la carpeta del estándar después de la matrícula del usuario
        $filePath = $request->file('documento')->storeAs(
            'public/documents/evidence/competencias/documentos/' . $user->matricula . '/' . Str::slug($estandar->nombre),
            $fileName
        );

        DocumentosEvidencias::create([
            'user_id' => Auth::id(),
            'estandar_id' => $estandarId, // Usar el estandar_id de la solicitud
            'documento_id' => $documento_id,
            'file_path' => $filePath,
            'nombre' => $documento->name,
            'estado' => 'pendiente',
        ]);

        return response()->json(['success' => true, 'message' => 'Documento subido correctamente']);
    }
}
