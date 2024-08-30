@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Evidencias Competencias</h1>
        <a href="{{ route('competencia.index', ['user_id' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        <!-- Información del usuario -->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4 shadow-sm border-light">
                    <div class="card-body d-flex align-items-center p-4">
                        <!-- Foto del usuario -->
                        <div class="rounded-circle overflow-hidden mr-3" style="width: 60px; height: 60px;">
                            <img src="{{ $usuario->foto }}" alt="Profile Picture" class="img-fluid rounded-circle"
                                width="60" height="60"
                                onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                        </div>
                        <!-- Información del usuario -->
                        <div>
                            <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Nombres:</strong>
                                {{ $usuario->name }} {{ $usuario->secondName }}</p>
                            <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Apellidos:</strong>
                                {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                            <p class="mb-0 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Edad:</strong>
                                {{ $usuario->age }} años</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Información de la competencia -->
        <div class="alert alert-info text-center">
            <strong>Estandar:</strong> {{ $competencia->name }}
        </div>

        <!-- Sección de evidencias -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Evidencias</h3>
            </div>
            <div class="card-body">
                @if ($fichas->isEmpty() && $cartas->isEmpty() && $documentos->isEmpty())
                    <div class="text-center text-muted">
                        <p>Por el momento este usuario no tiene ninguna evidencia de competencias.</p>
                    </div>
                @else
                    <table class="table table-striped table-bordered">
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
                                            class="btn btn-primary btn-sm">Ver Archivo</a>
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
                                            class="btn btn-info btn-sm">Ver Ficha</a>
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
                                            class="btn btn-info btn-sm">Ver Carta</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Sección para validar fichas -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Validar Fichas</h3>
            </div>
            <div class="card-body">
                @if ($fichas->isNotEmpty())
                    <table class="table table-striped table-bordered">
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
                                                class="btn btn-primary btn-sm">
                                                Validar Ficha
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted">
                        <p>No hay fichas para validar.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección para validar cartas -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-white">
                <h3 class="mb-0">Validar Cartas</h3>
            </div>
            <div class="card-body">
                @if ($cartas->isNotEmpty())
                    <table class="table table-striped table-bordered">
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
                                                class="btn btn-primary btn-sm">
                                                Validar Carta
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted">
                        <p>No hay cartas para validar.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección para validar documentos -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h3 class="mb-0">Validar Documentos</h3>
            </div>
            <div class="card-body">
                @if ($documentos->isNotEmpty())
                    <table class="table table-striped table-bordered">
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
                                                class="btn btn-primary btn-sm">
                                                Validar Documentos Evidencias
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted">
                        <p>No hay documentos para validar.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sección para validar comprobantes -->
        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">Validar Comprobantes</h3>
            </div>
            <div class="card-body">
                @if ($fichas_pago->isNotEmpty())
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Comprobante</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fichas_pago as $comprobante)
                                <tr>
                                    <td>{{ basename($comprobante->comprobante_pago) }}</td>
                                    <td>
                                        @if (isset($comprobantes_validaciones[$comprobante->id]) &&
                                                $comprobantes_validaciones[$comprobante->id]->tipo_validacion)
                                            <span class="text-success">Comprobante validado</span>
                                        @else
                                            <a href="{{ route('comprobantes.show', ['user_id' => $usuario->id, 'competencia' => $competencia]) }}"
                                                class="btn btn-primary btn-sm">
                                                Validar Comprobante
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center text-muted">
                        <p>No hay comprobantes para validar.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection



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
