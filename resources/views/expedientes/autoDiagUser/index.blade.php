@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card modern-card">
        <div class="card-body">
            <div class="text-center">
                <h2>Autodiagnósticos Disponibles</h2>
            </div>
        </div>
    </div>
@stop

@section('content')
    <form action="#" method="POST" id="autodiagnosticoForm">
        @csrf
        @foreach ($autodiagnosticos as $autodiagnostico)
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <h4 class="text-center">{{ $autodiagnostico->titulo }}</h4>
                </div>
                <br>
                <p class="text-center">{{ $autodiagnostico->descripcion }}</p>
                <br>
                <div class="card">
                    <div class="card-body">
                        <h5 class="bg-secondary text-white text-center p-2">PROPÓSITO DEL DIAGNÓSTICO</h5>
                        <div class="card-body">
                            <h6>
                                Servir como referente para la evaluación y certificación de las personas que diseñan
                                cursos
                                de
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
                        <h5 class="bg-warning text-white text-center p-2">INSTRUCCIONES
                        </h5>
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
                        <div class="card-body">
                            @php
                                // Contar el total de elementos
                                $totalElementos = $elementos
                                    ->where('autodiagnostico_id', $autodiagnostico->id)
                                    ->count();
                                $contadorElemento = 1; // Inicializa el contador para los elementos
                            @endphp

                            @foreach ($elementos as $elemento)
                                @if ($elemento->autodiagnostico_id == $autodiagnostico->id)
                                    <!-- Asegura que el elemento pertenece al autodiagnóstico -->
                                    <div class="card mt-2">
                                        <div class="card-header bg-info text-white">
                                            <h5>Elemento {{ $contadorElemento }} de {{ $totalElementos }}:
                                                {{ $elemento->nombre }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="text-center">CRITERIOS A DIAGNOSTICAR</h5>
                                            @foreach ($criterios as $criterio)
                                                @if ($criterio->elemento_id == $elemento->id)
                                                    <!-- Asegura que el criterio pertenece al elemento -->
                                                    <div class="mt-3">
                                                        <div class="position-relative">
                                                            <h6 class="bg-info text-white text-center p-2">
                                                                Con relación a este elemento, ¿usted obtiene los siguientes
                                                                {{ $criterio->nombre }}?
                                                            </h6>
                                                            <div
                                                                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.5);">
                                                            </div>
                                                        </div>

                                                        @php
                                                            // Filtra las preguntas que pertenecen al criterio actual
                                                            $preguntasDelCriterio = $preguntas->where(
                                                                'criterio_id',
                                                                $criterio->id,
                                                            );
                                                            // Agrupa las preguntas filtradas por su título
                                                            $preguntasAgrupadas = $preguntasDelCriterio->groupBy(
                                                                'titulo',
                                                            );
                                                        @endphp

                                                        @foreach ($preguntasAgrupadas as $titulo => $grupoPreguntas)
                                                            <!-- Mostrar el título solo una vez -->
                                                            <div class="position-relative">
                                                                <h6 class="bg-secondary text-white text-center p-2">
                                                                    {{ $titulo }}</h6>
                                                                <div
                                                                    style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.5);">
                                                                </div>
                                                            </div>

                                                            @php
                                                                // Inicializa el contador para las preguntas
                                                                $contador = 1;
                                                            @endphp

                                                            @foreach ($grupoPreguntas as $pregunta)
                                                                <!-- Asegura que la pregunta pertenece al criterio -->
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
                                                                                <input type="radio"
                                                                                    class="form-check-input"
                                                                                    id="pregunta_si_{{ $pregunta->id }}"
                                                                                    name="respuestas[{{ $pregunta->id }}]"
                                                                                    value="si" required>
                                                                                <label class="form-check-label"
                                                                                    for="pregunta_si_{{ $pregunta->id }}">Sí</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input type="radio"
                                                                                    class="form-check-input"
                                                                                    id="pregunta_no_{{ $pregunta->id }}"
                                                                                    name="respuestas[{{ $pregunta->id }}]"
                                                                                    value="no" required>
                                                                                <label class="form-check-label"
                                                                                    for="pregunta_no_{{ $pregunta->id }}">No</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    // Incrementa el contador para la siguiente pregunta
                                                                    $contador++;
                                                                @endphp
                                                            @endforeach
                                                        @endforeach
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @php
                                        // Incrementa el contador para el siguiente elemento
                                        $contadorElemento++;
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="card">
            <div-card-body>

            </div-card-body>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
        </div>
    </form>
@stop
