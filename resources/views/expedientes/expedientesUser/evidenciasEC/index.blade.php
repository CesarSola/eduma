@extends('adminlte::page')

@section('title', 'Evidencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">{{ $estandar->name }}</h1>
        </div>
        <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')

    <div class="container">
        <div class="card">
            @if (!$ficha_registro)
                <div class="card">
                    <h6 class="card-header bg-success text-white text-center font-weight-bold">Carta de Firma
                        Digital y Ficha de Inscripción</h6>
                    <div class="card-body text-center">
                        <form id="form-ficha-registro"
                            action="{{ route('generate-word', ['userId' => Auth::id(), 'standardId' => $estandar->id]) }}"
                            method="GET">
                            @csrf
                            <h6 class="card-title text-primary font-weight-bold">Descarga la Ficha de Inscripción
                            </h6>
                            <button type="submit" class="btn btn-success shadow-sm mt-3">Descargar Ficha</button>
                        </form>
                        @if (!$carta_firma)
                            <form id="form-carta-aceptacion"
                                action="{{ route('generate-carta', ['userId' => Auth::id()]) }}" method="GET">
                                @csrf
                                <h6 class="card-title text-primary font-weight-bold">Descarga la Carta de Firma
                                    Digital</h6>
                                <button type="submit" class="btn btn-success shadow-sm mt-3">Descargar
                                    Carta</button>
                            </form>
                        @endif
                    </div>
            @endif
            {{-- Mostrar la sección de subida de documentos solo si ambos documentos no han sido subidos --}}
            @if (!$ficha_registro || !$carta_firma)
                <h6 class="card-header bg-success text-white text-center font-weight-bold">Sube la Carta de Firma
                    Digital y Ficha de Registro</h6>
                <div class="card-body text-center">
                    {{-- Botón para subir la ficha --}}
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <h6 class="card-title text-primary font-weight-bold">Sube tu ficha de registro,
                            verificando
                            que los datos sean correctos y ya firmada</h6>
                        @if ($ficha_registro)
                            <br>
                            <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                                <p style="margin: 0;">Ya has subido la ficha de registro.</p>
                            </div>
                        @else
                            <br>
                            <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'ficha_registro']) }}"
                                class="btn btn-success shadow-sm">Subir ficha</a>
                        @endif
                    </div>
                    {{-- Botón para subir la carta de aceptación --}}
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <h6 class="card-title text-primary font-weight-bold">Sube tu carta de de Firma Digital,
                            leyendo detalladamente y ya firmada</h6>
                        @if ($carta_firma)
                            <br>
                            <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                                <p style="margin: 0;">Ya has subido la carta de firma digital.</p>
                            </div>
                        @else
                            <br>
                            <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'carta_firma']) }}"
                                class="btn btn-success shadow-sm">Subir carta</a>
                        @endif
                    </div>
                    @if (!$ficha_registro || !$carta_firma)
                        <div class="alert alert-info shadow-sm mt-4" role="alert">
                            Sube tanto la ficha de registro como la carta de tu firma digital, para ver la
                            sección
                            de los documentos necesarios que tienes que subir para este EC.
                        </div>
                    @endif
                </div>
        </div>
        @endif
        {{-- Mostrar validaciones solo si la carta y la ficha no están validadas --}}
        @if ($ficha_registro && $carta_firma && (!$carta_validada || !$ficha_validada))
            <div class="card">
                <h6 class="card-header bg-success text-white text-center font-weight-bold">Validaciones de
                    Carta y Ficha</h6>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Estado</th>
                                <th>Comentario</th>
                                <th>Acción</th> <!-- Columna para la acción -->
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Validaciones de fichas --}}
                            @foreach ($fichas_validaciones as $validacion)
                                <tr>
                                    <td>{{ $validacion->fichas->nombre ?? 'Nombre no disponible' }}</td>
                                    <td>{{ ucfirst($validacion->tipo_validacion) }}</td>
                                    <td>{{ $validacion->comentario }}</td>
                                    <td>
                                        {{-- Lógica para la acción si es necesario --}}
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Validaciones de cartas --}}
                            @foreach ($cartas_validaciones as $validacion)
                                <tr>
                                    <td>{{ $validacion->cartas->nombre ?? 'Nombre no disponible' }}</td>
                                    <td>{{ ucfirst($validacion->tipo_validacion) }}</td>
                                    <td>{{ $validacion->comentario }}</td>
                                    <td>
                                        {{-- Lógica para la acción si es necesario --}}
                                    </td>
                                </tr>
                            @endforeach

                            @if ($fichas_validaciones->isEmpty() && $cartas_validaciones->isEmpty())
                                <tr>
                                    <td class="text-muted" colspan="4">No hay validaciones disponibles</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if ($carta_validada && $ficha_validada)
            @if (!$todos_documentos_validos)
                <div class="card">
                    @if (!$hay_evidencias_subidas)
                        <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                            Descarga los formatos de los documentos y adáptalos a tus necesidades, luego súbelos
                            para su
                            revisión y aprobación.
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-header bg-success text-white text-center font-weight-bold">Evidencias
                            Para Subir</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Nombre</th>
                                        <th>Ver</th>
                                        <th>Descargar documento</th>
                                        <th>Subir Evidencias</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($documentos_necesarios as $documento)
                                        @php
                                            $documento_subido = $documento->isSubidoPorUsuario(
                                                auth()->id(),
                                                $estandar->id,
                                            );
                                        @endphp
                                        <tr>
                                            <td>{{ $documento->name }}</td>
                                            <td>{{ $documento->description }}</td>
                                            <td class="text-center align-middle">
                                                <a href="{{ Storage::url($documento->documento) }}" target="_blank"
                                                    class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="{{ route('document.download', $documento->id) }}"
                                                    class="btn btn-danger btn-sm shadow-sm">Descargar</a>
                                            </td>
                                            <td class="text-center align-middle">
                                                @if (!$documento_subido)
                                                    <button type="button" class="btn btn-success btn-sm shadow-sm"
                                                        data-bs-toggle="modal" data-bs-target="#uploadEvidenceModal"
                                                        data-documento-id="{{ $documento->id }}"
                                                        data-estandar-id="{{ $estandar->id }}"
                                                        data-documento-name="{{ $documento->name }}">
                                                        Subir Documento
                                                    </button>
                                                @else
                                                    <span class="badge bg-info">Subido</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($documentos_necesarios->isEmpty())
                                        <tr>
                                            <td class="text-muted" colspan="4">No se han subido documentos.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($documentos_necesarios->isNotEmpty())
                        <div class="card-header bg-success text-white text-center font-weight-bold">Verifica el
                            estado de
                            tus
                            evidencias en la siguiente pestaña</div>
                        <div class="card-body text-center">
                            <a class="btn btn-success mt-4"
                                href="{{ route('mis.evidencias', ['id' => $estandar->id, 'user_id' => auth()->id(), 'name' => $estandar->name]) }}">
                                Ir a mis Evidencias Subidas
                            </a>
                        </div>
                </div>
            @endif
        @endif
        @endif
        @if ($fechas_elegidas->isEmpty())
            @if ($todos_documentos_validos)
                @if ($carta_validada && $ficha_validada)
                    <div class="card">
                        <div class="card-header bg-success text-white text-center font-weight-bold">
                            Elige una Fecha para el plan de evaluación en la siguiente pestaña
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ route('fechas.index', ['estandar_id' => $estandar]) }}" class="btn btn-success">
                                Ir a Elegir Fecha del Plan de Evaluación
                            </a>
                        </div>
                    </div>
                @endif
            @endif
        @endif
        @if (!$plan_evaluacion_subido || !$cedula_evaluacion_subido)
            @if ($fechas_elegidas->isNotEmpty())
                <div class="card">
                    <div class="card-body">
                        <div class="card-header bg-success text-white text-center font-weight-bold">
                            Fecha Elegida
                        </div>
                        @if ($fechas_elegidas->isNotEmpty())
                            <ul class="list-unstyled">
                                @foreach ($fechas_elegidas as $fecha)
                                    <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <div class="d-flex flex-column flex-fill">
                                            <span class="font-weight-bold">Fecha:</span>
                                            <span>{{ $fecha->fechaCompetencia->fecha->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="d-flex flex-column flex-fill text-center">
                                            <span class="font-weight-bold">Horario:</span>
                                            <span>{{ $fecha->horaFormatted }}</span>
                                        </div>
                                        <div class="d-flex flex-column flex-fill text-right">
                                            @if ($evaluador)
                                                <span class="font-weight-bold">Evaluador:</span>
                                                <span>{{ $evaluador->evaluador->name }}
                                                    {{ $evaluador->evaluador->secondName }}
                                                    {{ $evaluador->evaluador->paternalSurname }}
                                                    {{ $evaluador->evaluador->maternalSurname }}</span>
                                            @else
                                                <span class="text-muted">Sin evaluador asignado</span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted text-center">No has elegido ninguna fecha aún.</p>
                        @endif
                        @if (!$cedula_evaluacion_subido)
                            <!-- Sección para subir la cédula de evaluación -->
                            <div class="card">
                                <div class="card-header bg-success text-white text-center font-weight-bold">Sube tu Cédula
                                    de Evaluación</div>
                                <div class="card-body">
                                    <div class="mb-3 d-flex flex-column align-items-center">
                                        <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                                            Sube la Cédula de Evaluación que tu @if ($evaluador)
                                                <span class="font-weight-bold">Evaluador:</span>
                                                <span>{{ $evaluador->evaluador->name }}
                                                    {{ $evaluador->evaluador->secondName }}
                                                    {{ $evaluador->evaluador->paternalSurname }}
                                                    {{ $evaluador->evaluador->maternalSurname }}</span>
                                            @else
                                                <span class="text-muted">Sin evaluador asignado</span>
                                            @endif te dará el día de la reunión de tu Plan de
                                            Evaluación.
                                        </div>
                                        <!-- Botón para abrir el modal -->
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#uploadCedulaModal">
                                            Subir Cédula de Evaluación
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Sección para el plan de evaluación -->
                            @if (!$plan_evaluacion_subido)
                                <div class="card">
                                    <div class="card-header bg-success text-white text-center font-weight-bold">Descarga tu
                                        Plan de Evaluación</div>
                                    <div class="card-body">
                                        <form id="form-plan"
                                            action="{{ route('generate-plan', ['userId' => Auth::id(), 'standardId' => $estandar->numero]) }}"
                                            method="GET">
                                            @csrf
                                            <div class="mb-3 d-flex flex-column align-items-center">
                                                <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                                                    Descarga tu Plan de Evaluación y léelo detalladamente. Tu @if ($evaluador)
                                                        <span class="font-weight-bold">Evaluador:</span>
                                                        <span>{{ $evaluador->evaluador->name }}
                                                            {{ $evaluador->evaluador->secondName }}
                                                            {{ $evaluador->evaluador->paternalSurname }}
                                                            {{ $evaluador->evaluador->maternalSurname }}</span>
                                                    @else
                                                        <span class="text-muted">Sin evaluador asignado</span>
                                                    @endif te dará más información.
                                                </div>
                                                <button type="submit" class="btn btn-success shadow-sm mt-3">Descargar
                                                    Plan</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-header bg-success text-white text-center font-weight-bold">Sube tu
                                        Plan de Evaluación</div>
                                    <div class="card-body">
                                        <div class="mb-3 d-flex flex-column align-items-center">
                                            <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                                                Súbelo hasta el día de la @foreach ($fechas_elegidas as $fecha)
                                                    <span class="font-weight-bold">Fecha:</span>
                                                    <span>{{ $fecha->fechaCompetencia->fecha->format('d/m/Y') }}</span>
                                                @endforeach escogida entre tú y tu evaluador.
                                            </div>
                                            <!-- Botón para abrir el modal -->
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#uploadPlanModal">
                                                Subir Plan de Evaluación
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        @endif
        @if ($plan_evaluacion_subido && $cedula_evaluacion_subido)
            @if (!$juicio_competencia_subido)
                <div class="card">
                    <div class="card-header bg-success text-white text-center font-weight-bold">Sube los
                        resultados de tu
                        evaluación
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex flex-column align-items-center">
                            <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                                Sube los resultados de los
                                juicios de
                                competencia
                                que tu @if ($evaluador)
                                    <span class="font-weight-bold">Evaluador:</span>
                                    <span>{{ $evaluador->evaluador->name }}
                                        {{ $evaluador->evaluador->secondName }}
                                        {{ $evaluador->evaluador->paternalSurname }}
                                        {{ $evaluador->evaluador->maternalSurname }}</span>
                                @else
                                    <span class="text-muted">Sin evaluador asignado</span>
                                @endif te dió al finalizar las pruebas de tu evaluación
                            </div>
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#uploadJuicioModal">
                                Subir Juicio de Competencia
                            </button>
                        </div>

                    </div>
                </div>
            @endif
        @endif
        @if ($plan_evaluacion_subido && $cedula_evaluacion_subido && $juicio_competencia_subido)
            @if ($comprobante_pago_subido)
                <!-- Sección visible solo cuando el comprobante de pago ya ha sido subido -->
                <div class="card">
                    <div class="card-header bg-success text-white text-center font-weight-bold">
                        Comprobante de Pago Subido
                    </div>
                    <div class="card-body">
                        <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                            El comprobante de pago ya ha sido subido. Cuando empiece el proceso, podrás
                            darle seguimiento con un mensaje
                            que te llegará al correo con el que te inscribiste
                            <br>
                        </div>
                        <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                            Edumatics / PowerSkills and Talent Management S.A.S. agredece tu confianza, al participar por la
                            certificación en este estándar de la mano con la página del Sistema Innovador de Centro
                            Evaluador (SICE).
                        </div>
                        <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                            El Promedio Obtenido fue de: {{ $promedio }}, y la calificación minima requerida para la
                            certificación del estandar: {{ $estandar->numero }} {{ $estandar->name }} fue de:
                            {{ $calificacion_minima }}
                        </div>
                    </div>
                </div>
            @else
                @if ($promedio >= $calificacion_minima)
                    <div class="card">
                        <div class="card-header bg-success text-white text-center font-weight-bold">
                            Sube el pago de tu Cédula de Certificación
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex flex-column align-items-center">
                                <div class="alert text-center alert-info shadow-sm mt-4" role="alert">
                                    Sube el comprobante de pago verificando que el monto sea el que te dió tu
                                    @if ($evaluador)
                                        <span class="font-weight-bold">Evaluador:</span>
                                        <span>{{ $evaluador->evaluador->name }} {{ $evaluador->evaluador->secondName }}
                                            {{ $evaluador->evaluador->paternalSurname }}
                                            {{ $evaluador->evaluador->maternalSurname }}</span>
                                    @else
                                        <span class="text-muted">Sin evaluador asignado</span>
                                    @endif para empezar el proceso de certificación
                                </div>
                                <a href="{{ route('certificacion.show', ['certificacion' => $estandar->id]) }}"
                                    class="btn btn-primary">Subir Comprobante para Certificación</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header bg-danger text-white text-center font-weight-bold">
                            Calificación Insuficiente
                        </div>
                        <div class="card-body">
                            <div class="alert text-center alert-danger shadow-sm mt-4" role="alert">
                                Tu promedio de calificaciones es {{ number_format($promedio, 2) }} y no cumple con la
                                calificación mínima de {{ $calificacion_minima }} para poder proceder con el proceso de
                                certificación.
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endif


    </div>
    @if (!$cedula_evaluacion_subido)
        @if ($fechas_elegidas->isNotEmpty())
            @include('expedientes.expedientesUser.evidenciasEC.CedulaEvaluacion.show')
        @endif
    @endif

    @if (!$plan_evaluacion_subido)
        @if ($fechas_elegidas->isNotEmpty())
            @include('expedientes.expedientesUser.evidenciasEC.PlanEvaluacion.show')
        @endif
    @endif

    @if (!$juicio_competencia_subido)
        @include('expedientes.expedientesUser.evidenciasEC.juicios.show')
    @endif

    @if ($carta_validada && $ficha_validada)
        @if (!$todos_documentos_validos)
            @if (!$hay_evidencias_subidas)
                @include('expedientes.expedientesUser.evidenciasEC.show')
            @endif
        @endif
    @endif
    </div>
@stop

@section('css')
    <style>
        .card {
            background-color: #f9f9f9;
            border: 1px solid #24b83a;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card {
            border-radius: 0.75rem;
            /* Bordes redondeados */
        }

        .card-header {
            border-bottom: 2px solid #33b300;
            /* Borde inferior para el encabezado */
            background-color: #33b300;
            /* Fondo azul oscuro */
            color: #ffffff;
            /* Texto blanco */
            font-size: 1.25rem;
            /* Tamaño de fuente aumentado */
            font-weight: bold;
            /* Negrita */
        }

        .card-body {
            padding: 1.25rem;
            /* Relleno adicional para el cuerpo */
        }

        .card-body ul {
            padding-left: 0;
            /* Elimina el relleno de la lista */
        }

        .card-body li {
            padding: 0.5rem 0;
            /* Espaciado interno en los elementos de la lista */
            border-bottom: 1px solid #dee2e6;
            /* Borde inferior sutil */
        }

        .card-body .font-weight-bold {
            font-weight: bold;
            /* Negrita para etiquetas */
        }

        .card-body .text-muted {
            font-style: italic;
            /* Estilo de fuente en cursiva para texto sin datos */
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            padding: 10px;
            border-radius: 5px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #007302;
            background-color: #fff;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .btn-sm {
            font-size: 0.8em;
            padding: 0.25em 0.5em;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        .thead-dark th {
            color: #fff;
            background-color: #00366d;
            border-color: #454d55;
        }

        .text-primary {
            color: #007bff !important;
        }

        /* Colores personalizados */
        .alert-secondary {
            background-color: #f8f9fa;
            /* Fondo claro */
            border-color: #ced4da;
            /* Borde gris */
            color: #6c757d;
            /* Texto gris */
        }

        /* Sombra sutil */
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        /* Márgenes y rellenos */
        .mt-4 {
            margin-top: 1.5rem !important;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: .375rem;
            /* Bordes redondeados */
            font-size: 1rem;
            /* Tamaño de fuente */
        }

        /* Texto centrado */
        .alert p {
            margin-bottom: 0;
            text-align: center;
        }

        .table td {
            vertical-align: middle;
            /* Alinea verticalmente el contenido dentro de las celdas de la tabla */
        }

        .text-center {
            text-align: center;
            /* Centra el texto horizontalmente */
        }

        .align-middle {
            vertical-align: middle;
            /* Alinea verticalmente el contenido dentro de las celdas */
        }

        .btn {
            display: inline-block;
            /* Asegura que los botones se comporten como elementos en línea */
            font-size: 0.8em;
            /* Tamaño de fuente para botones */
            padding: 0.375rem 0.75rem;
            /* Tamaño de padding uniforme */
            border-radius: 0.375rem;
            /* Bordes redondeados */
            line-height: 1.5;
            /* Altura de línea para centrar el texto verticalmente */
        }

        .btn-sm {
            font-size: 0.8em;
            /* Tamaño de fuente para botones pequeños */
            padding: 0.25rem 0.5rem;
            /* Padding uniforme */
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
            /* Sombra pequeña */
        }

        .badge {
            font-size: 0.75em;
            /* Tamaño de fuente para las insignias */
            padding: 0.25em 0.4em;
            /* Padding uniforme */
            border-radius: 0.25rem;
            /* Bordes redondeados */
        }

        .badge.bg-info {
            background-color: #17a2b8;
            /* Color de fondo para la insignia */
            color: #fff;
            /* Color del texto */
        }
    </style>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

@stop
