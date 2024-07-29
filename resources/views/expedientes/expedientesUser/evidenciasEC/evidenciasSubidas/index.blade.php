@extends('adminlte::page')

@section('title', 'Evidencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">Evidencias Subidas para {{ $estandarName }} de {{ $usuarioName }}</h1>
        </div>
        <a href="{{ route('evidenciasEC.index', ['id' => $estandarId, 'name' => $estandarName]) }}"
            class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Documentos y Estado de Validación</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre del Documento</th>
                            <th>Usuario ID</th>
                            <th>Estándar ID</th>
                            <th>Documento ID</th>
                            <th>Estado de Validación</th>
                            <th>Comentario</th>
                            <th>Acciones</th> <!-- Nueva columna para acciones -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documentos as $documento)
                            <tr>
                                <td>{{ $documento->nombre }}</td> <!-- Nombre directamente desde DocumentosEvidencias -->
                                <td>{{ $documento->user_id }}</td>
                                <td>{{ $documento->estandar_id }}</td>
                                <td>{{ $documento->documento_id }}</td>
                                <td>
                                    @php
                                        // Encuentra la validación más reciente para este documento
                                        $validacion = $documento->validacionesEvidencias->last();
                                    @endphp

                                    @switch($validacion ? $validacion->tipo_validacion : 'pendiente')
                                        @case('validar')
                                            <span class="badge badge-success">Validado</span>
                                        @break

                                        @case('rechazar')
                                            <span class="badge badge-danger">Rechazado</span>
                                        @break

                                        @case('pendiente')
                                            <span class="badge badge-warning">En Proceso</span>
                                        @break

                                        @default
                                            <span class="badge badge-secondary">Desconocido</span>
                                    @endswitch
                                </td>
                                <td>{{ $validacion ? $validacion->comentario : 'Sin comentarios' }}</td>
                                <td>
                                    @if ($validacion && $validacion->tipo_validacion === 'rechazar')
                                        <a href="{{ route('evidencias.resubir', ['id' => $documento->id]) }}"
                                            class="btn btn-warning btn-sm shadow-sm">Resubir</a>
                                    @endif
                                    @if ($validacion && $validacion->tipo_validacion === 'pendiente')
                                        <span class="badge badge-info">Esperando Revisión</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
