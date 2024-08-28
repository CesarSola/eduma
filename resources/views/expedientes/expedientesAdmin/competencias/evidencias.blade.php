@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Evidencias Competencias</h1>
        <a href="{{ route('competencia.index', ['user_id' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body header-flex">
                            <div class="left-content">
                                <h6 class="text-left mt-2">
                                    Nombres: {{ $usuario->name }} {{ $usuario->secondName }}
                                </h6>
                                <h6 class="text-left mt-2">Apellidos: {{ $usuario->paternalSurname }}
                                    {{ $usuario->maternalSurname }}</h6>
                                <h6 class="text-left mt-2">Edad: {{ $usuario->age }} años</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert alert-info">
                <p class="text-center"><strong>Estandar:</strong> {{ $competencia->name }}</p>
            </div>
            <!-- Sección de evidencias -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3>Evidencias</h3>
                        </div>
                        <div class="card-body">
                            @if ($fichas->isEmpty() && $cartas->isEmpty() && $documentos->isEmpty())
                                <div class="text-center">
                                    <p class="text-muted">Por el momento este usuario no tiene ninguna evidencia de
                                        competencias.</p>
                                </div>
                            @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo de Documento</th>
                                            <th>Nombre del Documento</th>
                                            <th>Competencia</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($documentos as $documento)
                                            <tr>
                                                <td>{{ $documento->id }}</td>
                                                <td>Documento</td>
                                                <td>{{ $documento->documento->name ?? 'Documento no disponible' }}</td>
                                                <td>{{ $documento->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($documento->file_path) }}" target="_blank"
                                                        class="btn btn-primary btn-sm shadow-sm">Ver Archivo</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach ($fichas as $ficha)
                                            <tr>
                                                <td>{{ $ficha->id }}</td>
                                                <td>Ficha de Registro</td>
                                                <td>{{ $ficha->nombre ?? 'Ficha no disponible' }}</td>
                                                <td>{{ $ficha->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($ficha->file_path) }}" target="_blank"
                                                        class="btn btn-info btn-sm shadow-sm">Ver Ficha</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @foreach ($cartas as $carta)
                                            <tr>
                                                <td>{{ $carta->id }}</td>
                                                <td>Carta de Firma</td>
                                                <td>{{ $carta->nombre ?? 'Carta no disponible' }}</td>
                                                <td>{{ $carta->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($carta->file_path) }}" target="_blank"
                                                        class="btn btn-info btn-sm shadow-sm">Ver Carta</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sección para validar fichas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Validar Fichas</h3>
                </div>
                <div class="card-body">
                    @if ($fichas->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ficha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fichas as $ficha)
                                    <tr>
                                        <td>{{ $ficha->nombre }}</td>
                                        <td>
                                            @if (isset($fichas_validaciones[$ficha->id]) && $fichas_validaciones[$ficha->id]->tipo_validacion)
                                                <span class="text-success">Ficha validada</span>
                                            @else
                                                <a href="{{ route('fichas.show', ['user_id' => $usuario->id, 'competencia' => $competencia]) }}"
                                                    class="btn btn-primary">
                                                    Validar Ficha
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p class="text-muted">No hay fichas para validar.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sección para validar cartas -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Validar Cartas</h3>
                </div>
                <div class="card-body">
                    @if ($cartas->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Carta</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartas as $carta)
                                    <tr>
                                        <td>{{ $carta->nombre }}</td>
                                        <td>
                                            @if (isset($cartas_validaciones[$carta->id]) && $cartas_validaciones[$carta->id]->tipo_validacion)
                                                <span class="text-success">Carta validada</span>
                                            @else
                                                <a href="{{ route('cartas.show', ['user_id' => $usuario->id, 'competencia' => $competencia]) }}"
                                                    class="btn btn-primary">
                                                    Validar Carta
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p class="text-muted">No hay cartas para validar.</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Sección para validar documentos -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Validar Documentos</h3>
                </div>
                <div class="card-body">
                    @if ($documentos->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 70%;">Documento</th>
                                    <th style="width: 30%;">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <tr>
                                        <td>{{ $documento->documento->name ?? 'Documento no disponible' }}</td>
                                        <td>
                                            @php
                                                // Verifica el estado de validación del documento
                                                $estado_validacion =
                                                    $documentos_validaciones[$documento->id]->tipo_validacion ??
                                                    'pendiente';
                                            @endphp
                                            @if ($estado_validacion === 'validar')
                                                <span class="text-success">Documento validado</span>
                                            @elseif ($estado_validacion === 'rechazar')
                                                <span class="text-danger">Documento rechazado</span>
                                            @else
                                                <a href="{{ route('documentosE.show', ['user_id' => $usuario->id, 'competencia_id' => $competencia->id]) }}"
                                                    class="btn btn-primary">
                                                    Validar Documentos Evidencias
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p class="text-muted">No hay documentos para validar.</p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Sección para validar fichas de pago de certificados -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Validar Fichas de Pago de Certificados</h3>
                </div>
                <div class="card-body">
                    @if ($fichas_pago->isNotEmpty())
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ficha de Pago</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fichas_pago as $ficha_pago)
                                    <tr>
                                        <td>{{ basename($ficha_pago->comprobante_pago) }}</td>
                                        <td>
                                            @if (isset($fichas_pago_validaciones[$ficha_pago->id]) && $fichas_pago_validaciones[$ficha_pago->id]->tipo_validacion)
                                                <span class="text-success">Ficha de Pago validada</span>
                                            @else
                                                <a href="{{ route('validarCE.show', ['validarCE' => $usuario->id, 'competencia' => $competencia->id, 'user_id' => $usuario->id]) }}"
                                                    class="btn btn-primary">
                                                    Ver Comprobantes de Pago
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p class="text-muted">No hay fichas de pago para validar.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop


@section('css')
    <style>
        .card-title {
            background-color: #067dd2;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .text-center {
            color: #000000;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .toggle-card {
            cursor: pointer;
        }

        .action-cell {
            display: flex;
            justify-content: flex-start;
            /* Alinea el contenido a la izquierda */
            align-items: center;
            /* Centra verticalmente el contenido */
        }

        .alert-info {
            color: #0c5460;
            background-color: #9eeefd;
            border-color: #9cdee8;
            padding: 10px;
            border-radius: 5px;
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
