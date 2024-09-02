@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Expediente</h1>
        <a href="{{ route('usuariosAdmin.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-light">
                    <div class="card-body d-flex align-items-center">
                        <!-- Foto del usuario -->
                        <div class="rounded-circle overflow-hidden mr-3" style="width: 60px; height: 60px;">
                            <img src="{{ $usuariosAdmin->foto }}" alt="Profile Picture" class="img-fluid rounded-circle"
                                width="60" height="60"
                                onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                        </div>
                        <!-- Información del usuario -->
                        <div class="flex-grow-1">
                            <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Nombres:</strong>
                                {{ $usuariosAdmin->name }} {{ $usuariosAdmin->secondName }}</p>
                            <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Apellidos:</strong>
                                {{ $usuariosAdmin->paternalSurname }} {{ $usuariosAdmin->maternalSurname }}</p>
                            <p class="mb-0 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Edad:</strong>
                                {{ $usuariosAdmin->age }} años</p>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success mt-2" data-toggle="modal" data-target="#edit">
                                Editar
                            </button>
                        </div>
                        <!-- Badges -->
                        <div class="ml-3 d-flex flex-column">
                            @if ($documentos->isNotEmpty())
                                @if ($documentosCompletos)
                                    <div><span class="badge badge-success">Documentos Generales: Completos y
                                            Validados</span></div>
                                @elseif ($documentosEnValidacion)
                                    <div><span class="badge badge-info">Documentos Generales: En Validación</span></div>
                                @else
                                    <div><span class="badge badge-warning">Documentos Generales: Incompletos</span></div>
                                @endif
                            @else
                                <div><span class="badge badge-danger">Documentos Generales: Ninguno</span></div>
                            @endif

                            @if ($cursos->isNotEmpty())
                                @if ($comprobanteSubidoCU && $comprobanteEnValidacionCU)
                                    <div><span class="badge badge-info">Cursos: En Validación</span></div>
                                @else
                                    <div><span class="badge badge-success">Cursos: Inscrito</span></div>
                                @endif
                            @else
                                <div><span class="badge badge-danger">Cursos: Ninguno</span></div>
                            @endif

                            @if ($estandares->isNotEmpty())
                                @if ($comprobanteSubidoCO && $comprobanteEnValidacionCO)
                                    <div><span class="badge badge-info">Competencias: En Validación</span></div>
                                @else
                                    <div><span class="badge badge-success">Competencias: Inscrito</span></div>
                                @endif
                            @else
                                <div><span class="badge badge-danger">Competencias: Ninguno</span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row mt-3">
                    <!-- Documentos de Registro General -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-primary border-bottom">
                                <h3 class="card-title mb-0 text-center text-white" style="font-size: 1.25rem;">
                                    Ver Documentos de Registro General
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                                @if ($documentos->isNotEmpty())
                                    <a href="{{ route('registroGeneral.index', ['userId' => $usuariosAdmin->id]) }}"
                                        class="btn btn-primary mt-3">Ver Documentos</a>
                                @else
                                    <p class="mt-3 text-muted">No hay documentos disponibles para este usuario.</p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Estandares -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-primary border-bottom">
                                <h3 class="card-title mb-0 text-center text-white" style="font-size: 1.25rem;">
                                    Estandares de <br> {{ $usuariosAdmin->name }}
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if ($estandares->isNotEmpty())
                                    <ul class="list-group flex-grow-1 overflow-auto">
                                        @foreach ($estandares as $estandar)
                                            <li class="list-group-item">{{ $estandar->name }}</li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('competencia.index', ['user_id' => $usuariosAdmin->id]) }}"
                                        class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                                @else
                                    <div class="text-center mt-3">
                                        <p class="text-muted">No hay estándares disponibles para este usuario.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Cursos -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-header bg-primary border-bottom">
                                <h3 class="card-title mb-0 text-center text-white" style="font-size: 1.25rem;">
                                    Cursos de <br> {{ $usuariosAdmin->name }}
                                </h3>
                            </div>
                            <div class="card-body d-flex flex-column">
                                @if ($cursos->isNotEmpty())
                                    <ul class="list-group flex-grow-1 overflow-auto">
                                        @foreach ($cursos as $curso)
                                            <li class="list-group-item">{{ $curso->name }}</li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('cursosExpediente.index', ['user_id' => $usuariosAdmin->id]) }}"
                                        class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                                @else
                                    <div class="text-center mt-3">
                                        <p class="text-muted">No hay cursos disponibles para este usuario.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Validar Documentos -->
                    <div class="row mt-3">
                        <!-- Validar Documentos de Registro General -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title mb-0" style="font-size: 1.25rem;">
                                        Validar <br> Documentos de Registro General
                                    </h3>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    @if ($documentos->isEmpty())
                                        <div class="text-center mt-3">
                                            <p class="text-muted">No hay documentos disponibles para este usuario.</p>
                                        </div>
                                    @else
                                        <!-- Comprobar si todos los documentos están validados -->
                                        @if ($documentosCompletos)
                                            <p class="text-center mt-3 text-success">Todos los documentos ya han sido
                                                validados.</p>
                                        @elseif ($documentosEnValidacion)
                                            <p class="text-center mt-3 text-warning">Algunos documentos están en proceso de
                                                validación.</p>
                                        @else
                                            <ul class="list-group flex-grow-1 overflow-auto">
                                                @foreach ($documentos as $documento)
                                                    <li class="list-group-item">{{ basename($documento->ine_ife) }}</li>
                                                    <li class="list-group-item">
                                                        {{ basename($documento->comprobante_domiciliario) }}</li>
                                                    <li class="list-group-item">{{ basename($documento->foto) }}</li>
                                                    <li class="list-group-item">{{ basename($documento->curp) }}</li>
                                                @endforeach
                                            </ul>
                                            <div class="text-center mt-3">
                                                <!-- Mostrar el botón para ver documentos si hay documentos pendientes de validación -->
                                                <a href="{{ route('registroGeneral.show', $usuariosAdmin->id) }}"
                                                    class="btn btn-primary">Ver</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Validar Comprobantes de Pago Competencia -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title mb-0" style="font-size: 1.25rem;">Validar <br>Comprobantes de pago
                                        Competencia</h3>
                                </div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <div class="text-center">
                                        @if ($comprobantesCO->isEmpty())
                                            <p>No hay comprobantes de pago de competencias para validar.</p>
                                        @else
                                            <a href="{{ route('validarCoP.show', $usuariosAdmin->id) }}"
                                                class="btn btn-primary">
                                                Ver Comprobante de Pago Competencias
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Validar Comprobantes de Pago Cursos -->
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 border-light shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="card-title mb-0" style="font-size: 1.25rem;">Validar <br>Comprobantes de
                                        pago Cursos</h3>
                                </div>
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <div class="text-center">
                                        @if ($comprobantesCU->isEmpty())
                                            <p>No hay comprobantes de pago de cursos para validar.</p>
                                        @else
                                            <a href="{{ route('validarCuP.show', $usuariosAdmin->id) }}"
                                                class="btn btn-primary">
                                                Ver Comprobante de Pago Cursos
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            @if ($atencionUsuario->isNotEmpty())
                <div class="card">
                    <div class="card-header">
                        <h3>Encuestas de Satisfacción Respondidas</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre del Estándar</th>
                                    <th>Fecha del Examen</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($atencionUsuario as $atencion)
                                    <tr>
                                        <td>{{ $atencion->estandar->name }}</td>
                                        <td>{{ $atencion->fecha->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('formato-atencion.download', ['estandar_id' => $atencion->estandar_id]) }}"
                                                class="btn btn-info">Descargar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p>No hay encuestas de satisfacción respondidas para este usuario.</p>
            @endif

            <!-- Mostrar todas las encuestas de satisfacción -->
            <div class="col-md-12 mt-4">
                @if ($surveyResponses->isNotEmpty())
                    <div class="card">
                        <div class="card-header">
                            <h3>Encuestas de Satisfacción Respondidas</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre del Estándar</th>
                                        <th>Fecha del Examen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($surveyResponses as $response)
                                        <tr>
                                            <td>{{ $response->estandar->name ?? 'Nombre del estándar no disponible' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($response->exam_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <!-- Enlace para descargar la encuesta en formato DOCX -->
                                                <a href="{{ route('survey.downloadFile', $response->id) }}"
                                                    class="btn btn-info">Descargar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p>No hay encuestas de satisfacción respondidas para este usuario.</p>
                @endif
            </div>

        </div>
    </div>
    @include('expedientes.expedientesAdmin.usuarios.edit')
@stop

@section('css')
    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-content {
            width: 70%;
        }

        .right-content {
            text-align: right;
        }

        .right-content div {
            margin-bottom: 5px;
            /* Espacio entre cada badge */
        }

        .card-title {
            background-color: #067dd2;
            text-align: center;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .list-group-item {
            text-align: center;
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .overflow-auto {
            max-height: 200px;
            /* Adjust this height as needed */
            overflow-y: auto;
        }

        .btn-secondary {
            margin-left: auto;
        }

        .btn-success {
            align-content: center;
            width: 50%;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para recargar la sección cada 5 minutos
        setInterval(function() {
            $.ajax({
                url: window.location.href, // URL actual, puede ser ajustada según necesidad
                type: 'GET', // Método de solicitud GET
                dataType: 'html', // Tipo de datos esperado (html en este caso)
                success: function(response) {
                    // Actualizar el contenido de la sección específica
                    var updatedContent = $(response).find('#1');
                    $('#1').html(updatedContent.html());
                }
            });
        }, 3000); // 300000 milisegundos = 5 minutos
    </script>
@stop
