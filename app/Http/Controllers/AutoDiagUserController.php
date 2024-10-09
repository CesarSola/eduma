<?php

namespace App\Http\Controllers;

use App\Models\AutoDiag;
use App\Models\Criterio;
use App\Models\Elemento;
use App\Models\Estandares;
use App\Models\PregAutDiag;
use App\Models\RespAutDiag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoDiagUserController extends Controller
{
    public function index()
    {
        $estandar = Estandares::find(1);
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            // Obtén el ID del usuario autenticado
            $usuarioId = Auth::id();

            // Obtén los autodiagnósticos disponibles para el usuario
            $autodiagnosticos = AutoDiag::all();

            // Cargar los elementos, criterios y preguntas relacionados
            $elementos = Elemento::whereIn('autodiagnostico_id', $autodiagnosticos->pluck('id'))->get();
            $criterios = Criterio::whereIn('elemento_id', $elementos->pluck('id'))->get();
            $preguntas = PregAutDiag::whereIn('criterio_id', $criterios->pluck('id'))->get();

            // Verificar si el usuario ya ha respondido a este autodiagnóstico
            $autodiagnosticoId = $autodiagnosticos->first()->id;
            $yaRespondido = RespAutDiag::where('usuario_id', $usuarioId)
                ->where('autodiagnostico_id', $autodiagnosticoId)
                ->exists();

            // Cargar las respuestas y calcular resultados si ya ha respondido
            $resumenResultados = [];
            $porcentajeCorrectas = 0;

            if ($yaRespondido) {
                $respuestas = RespAutDiag::where('usuario_id', $usuarioId)
                    ->where('autodiagnostico_id', $autodiagnosticoId)
                    ->with('pregunta.criterio.elemento')
                    ->get();

                foreach ($respuestas as $respuesta) {
                    $elemento = $respuesta->pregunta->criterio->elemento->nombre;
                    $criterio = $respuesta->pregunta->criterio->nombre;
                    $respuestaUsuario = $respuesta->respuesta; // Aquí puede ser 'si' o 'no'

                    // Inicializa el array si no existe
                    if (!isset($resumenResultados[$elemento])) {
                        $resumenResultados[$elemento] = [
                            'si' => 0,
                            'no' => 0
                        ];
                    }

                    // Incrementa el contador de respuestas 'si' o 'no'
                    if ($respuestaUsuario === 'si') {
                        $resumenResultados[$elemento]['si']++;
                    } else {
                        $resumenResultados[$elemento]['no']++;
                    }
                }

                // Calcula el porcentaje de respuestas correctas
                $totalRespuestas = $respuestas->count();
                $totalCorrectas = $respuestas->where('correcta', 1)->count();
                $porcentajeCorrectas = $totalRespuestas > 0 ? ($totalCorrectas / $totalRespuestas) * 100 : 0;
            }
            // Verifica si el usuario ya ha respondido a este autodiagnóstico
            $yaRespondido = RespAutDiag::where('usuario_id', $usuarioId)
                ->where('autodiagnostico_id', $autodiagnosticoId)
                ->exists();

            // Cargar las respuestas y calcular resultados si ya ha respondido
            if ($yaRespondido) {
                $respuestas = RespAutDiag::where('usuario_id', $usuarioId)
                    ->where('autodiagnostico_id', $autodiagnosticoId)
                    ->with('pregunta.criterio.elemento') // Cargar las preguntas relacionadas
                    ->get();

                // Aquí puedes calcular el resumen de resultados si es necesario
                foreach ($respuestas as $respuesta) {
                    // Lógica para calcular los resultados, similar a como lo hacías antes...
                }
            } else {
                // Inicializa las respuestas como vacías si no ha respondido
                $respuestas = [];
            }


            // Retornar la vista con los datos necesarios
            return view('expedientes.autoDiagUser.index', compact(
                'autodiagnosticos',
                'elementos',
                'criterios',
                'preguntas',
                'yaRespondido',
                'resumenResultados',
                'porcentajeCorrectas',
                'estandar'
            ));
        } else {
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $usuarioId = Auth::id();
        $autodiagnosticoId = $request->input('autodiagnostico_id');
        $autodiagnostico = AutoDiag::find($autodiagnosticoId);

        if (!$autodiagnostico) {
            return redirect()->back()->with('error', 'El autodiagnóstico no fue encontrado.');
        }

        $estandarId = $autodiagnostico->estandar_id;

        foreach ($request->input('respuestas') as $preguntaId => $respuesta) {
            // Consulta la respuesta correcta de la pregunta
            $pregunta = PregAutDiag::find($preguntaId);

            if ($pregunta) {
                // Compara la respuesta del usuario con la respuesta correcta (sin importar mayúsculas)
                $correcta = (strtolower($pregunta->resp_correcta) === strtolower($respuesta));

                // Guarda las respuestas en la sesión
                session(['respuestas' => $request->input('respuestas')]);

                // Guarda la respuesta en la tabla resp_aut_diag
                RespAutDiag::create([
                    'usuario_id' => $usuarioId,
                    'estandar_id' => $estandarId,
                    'autodiagnostico_id' => $autodiagnosticoId,
                    'elemento_id' => $pregunta->elemento_id,
                    'criterio_id' => $pregunta->criterio_id,
                    'pregunta_id' => $preguntaId,
                    'respuesta' => $respuesta,
                    'correcta' => $correcta,
                ]);
            }
        }

        return redirect()->route('autoDiagUser.index', ['autodiagnostico' => $autodiagnosticoId]);
    }

    public function resultados($autodiagnosticoId)
    {
        $usuarioId = Auth::id();

        // Obtener todas las respuestas del usuario para el autodiagnóstico específico
        $respuestas = RespAutDiag::where('usuario_id', $usuarioId)
            ->where('autodiagnostico_id', $autodiagnosticoId)
            ->with('pregunta') // Cargar las preguntas relacionadas
            ->get();

        // Calcular el total de respuestas y el total de respuestas correctas
        $totalRespuestas = $respuestas->count();
        $totalCorrectas = $respuestas->where('correcta', 1)->count();

        // Calcular el porcentaje de respuestas correctas
        $porcentajeCorrectas = $totalRespuestas > 0 ? ($totalCorrectas / $totalRespuestas) * 100 : 0;

        // Retornar la vista de resultados con las respuestas y el porcentaje
        return view('expedientes.autoDiagUser.resultados', compact('respuestas', 'porcentajeCorrectas'));
    }
}
