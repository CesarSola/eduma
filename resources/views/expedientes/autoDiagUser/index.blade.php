@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="text-center">
                <h2>Autodiagnóstico del estandar {{ $estandar->name }}</h2>
            </div>
            <div class="float-end">
                <a href="{{ route('usuarios.index') }}" class="btn btn-primary">Regresar</a>
            </div>
        </div>
    </div>


@stop

@section('content')
    <form action="{{ route('autoDiagUser.store') }}" method="POST" id="autodiagnosticoForm">
        @csrf
        @foreach ($autodiagnosticos as $autodiagnostico)
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <input type="hidden" name="autodiagnostico_id" value="{{ $autodiagnostico->id }}">
                    <h4 class="text-center">{{ $autodiagnostico->titulo }}</h4>
                </div>
                <br>
                <p class="text-center">{{ $autodiagnostico->descripcion }}</p>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <h5 class="bg-secondary text-white text-center p-2">PROPÓSITO DEL DIAGNÓSTICO</h5>
                    <div class="card-body">
                        <h6>
                            Servir como referente para la evaluación y certificación de las personas que diseñan
                            cursos de
                            formación del capital humano de manera presencial grupal, sus instrumentos de evaluación
                            y
                            manuales del curso.
                        </h6>
                        <h6>
                            El estándar de competencia de diseño de cursos de formación del capital humano de manera
                            presencial grupal, sus instrumentos de evaluación y manuales del curso contempla las
                            funciones
                            sustantivas de diseñar cursos, diseñar instrumentos de evaluación y diseñar manuales.
                        </h6>
                        <h6>
                            Asimismo, puede ser referente para el desarrollo de programas de capacitación y de
                            formación
                            basados en el Estándar de Competencia.
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="bg-danger text-white text-center p-2">IMPORTANTE</h5>
                    <h6>
                        Diagnóstico de competencia laboral es un documento personal, particular y confidencial del
                        candidato a evaluación y certificación, sus resultados sólo se darán a conocer de manera
                        personal.
                    </h6>
                    <h6>
                        Con esta información el candidato decidirá si ingresa a los procesos de evaluación y
                        certificación
                        de la competencia laboral o asiste a un taller de capacitación final.
                    </h6>
                    <br>
                    <h5 class="bg-warning text-white text-center p-2">INSTRUCCIONES</h5>
                    <ol>
                        <li>Lea cuidadosamente cada uno de los apartados del Diagnóstico tomando en cuenta las
                            actividades que usted sabe hacer, bajo qué condiciones las ha realizado, cómo las ha
                            demostrado y qué conocimientos tiene de su actividad.</li>
                        <li> Lea cuidadosamente la pregunta de las actividades que se enuncian y marque en la
                            columna SI cuando considere que sabe hacer o ha hecho el producto, Actitudes / Hábito /
                            Valor o tiene el conocimiento y/o pueda mostrar las evidencias correspondientes y en la
                            columna NO en caso contrario.</li>
                        <li> Una vez que haya leído todo el Diagnóstico, revise sus respuestas las veces que
                            considere
                            necesario.</li>
                        <li> Tiempo máximo para elaborar el diagnóstico: 30 minutos</li>
                    </ol>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="text-center">APLICACIÓN DEL DIAGNÓSTICO</h5>
                    @php
                        // Contar el total de elementos
                        $totalElementos = $elementos->where('autodiagnostico_id', $autodiagnostico->id)->count();
                        $contadorElemento = 1; // Inicializa el contador para los elementos
                        $totalPreguntas = 0; // Inicializa el contador para las preguntas
                        $preguntasPorElemento = []; // Inicializa un array para preguntas por elemento
                    @endphp
                    @foreach ($elementos as $elemento)
                        @if ($elemento->autodiagnostico_id == $autodiagnostico->id)
                            <div class="card mt-2">
                                <div class="card-header bg-info text-white">
                                    <h5>Elemento {{ $contadorElemento }} de {{ $totalElementos }}:
                                        {{ $elemento->nombre }}</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-center">CRITERIOS A DIAGNOSTICAR</h5>
                                    @foreach ($criterios as $criterio)
                                        @if ($criterio->elemento_id == $elemento->id)
                                            <div class="mt-3">
                                                <h6 class="bg-info text-white text-center p-2">
                                                    {{ $criterio->nombre }}</h6>
                                                @php
                                                    // Filtrar las preguntas que pertenecen al criterio actual
                                                    $preguntasDelCriterio = $preguntas->where(
                                                        'criterio_id',
                                                        $criterio->id,
                                                    );
                                                    $preguntasAgrupadas = $preguntasDelCriterio->groupBy('titulo');
                                                    $numeroPreguntas = $preguntasDelCriterio->count();
                                                    $totalPreguntas += $numeroPreguntas;
                                                    $preguntasPorElemento[$elemento->nombre][
                                                        $criterio->nombre
                                                    ] = $numeroPreguntas;
                                                @endphp

                                                @foreach ($preguntasAgrupadas as $titulo => $grupoPreguntas)
                                                    <h6 class="bg-secondary text-white text-center p-2">
                                                        {{ $titulo }}</h6>
                                                    @php $contador = 1; @endphp

                                                    @foreach ($grupoPreguntas as $pregunta)
                                                        <div class="mb-3">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-9">
                                                                    <label for="pregunta_{{ $pregunta->id }}"
                                                                        class="form-label">
                                                                        {{ $contador }}.
                                                                        {{ $pregunta->pregunta }}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-3 text-end">
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input"
                                                                            id="pregunta_si_{{ $pregunta->id }}"
                                                                            name="respuestas[{{ $pregunta->id }}]"
                                                                            value="si"
                                                                            {{ (session('respuestas')[$pregunta->id] ?? '') == 'si' ? 'checked' : '' }}
                                                                            required>
                                                                        <label class="form-check-label"
                                                                            for="pregunta_si_{{ $pregunta->id }}">Sí</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" class="form-check-input"
                                                                            id="pregunta_no_{{ $pregunta->id }}"
                                                                            name="respuestas[{{ $pregunta->id }}]"
                                                                            value="no"
                                                                            {{ (session('respuestas')[$pregunta->id] ?? '') == 'no' ? 'checked' : '' }}
                                                                            required>
                                                                        <label class="form-check-label"
                                                                            for="pregunta_no_{{ $pregunta->id }}">No</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @php $contador++; @endphp
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @php $contadorElemento++; @endphp
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
        <!-- Tarjeta para mostrar el total de preguntas -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="bg-info text-white text-center p-2">Total de preguntas</h6>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Elemento</th>
                            <th scope="col">Criterio</th>
                            <th scope="col">Número de Preguntas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preguntasPorElemento as $elemento => $criterios)
                            @foreach ($criterios as $criterio => $cantidad)
                                <tr>
                                    <td>{{ $elemento }}</td>
                                    <td>{{ $criterio }}</td>
                                    <td>{{ $cantidad }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-4">
            @if (!$yaRespondido)
                <button type="submit" class="btn btn-success">Enviar Respuestas</button>
            @endif
        </div>
    </form>

    @if ($yaRespondido)
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="bg-info text-white text-center p-2">
                    Porcentaje de respuestas correctas: {{ number_format($porcentajeCorrectas, 2) }}%
                </h6>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Elemento</th>
                            <th>Total de respuestas "Sí"</th>
                            <th>Total de respuestas "No"</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resumenResultados as $elemento => $respuestas)
                            <tr>
                                <td>{{ $elemento }}</td>
                                <td>{{ $respuestas['si'] }}</td>
                                <td>{{ $respuestas['no'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body text-center"> <!-- Centra el contenido -->
                {{-- Mensaje del porcentaje obtenido --}}
                @if ($yaRespondido)
                    <h4 class="text-info">Obtuviste el {{ number_format($porcentajeCorrectas, 2) }}%</h4>
                @endif

                {{-- Botón basado en el porcentaje --}}
                @if ($porcentajeCorrectas > 90)
                    <a href="{{ route('competenciaEC.index') }}" class="btn btn-success">Inscríbete al Estándar
                        {{ $estandar->name }} </a>
                    <small class="form-text text-muted mt-2">¡Excelente trabajo! Estás listo para inscribirte.</small>
                @else
                    <a href="{{ route('registroCurso.index') }}" class="btn btn-warning">Inscríbete a un curso</a>
                    <small class="form-text text-muted mt-2">Considera mejorar tus respuestas con un curso.</small>
                @endif
            </div>
        </div>
    @endif
@stop

@section('css')
    <style>
        .card-body {
            border: 1px solid #dee2e6;
            /* Borde alrededor del cuerpo de la tarjeta */
            padding: 1rem;
            /* Espaciado interno */
        }

        h6 {
            font-weight: bold;
            /* Negrita para la conclusión */
        }

        p {
            color: #6c757d;
            /* Color gris para la frase */
        }
    </style>
@stop
