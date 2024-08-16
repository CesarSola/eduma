@extends('adminlte::page')

@section('title', 'Fechas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">Elige una fecha</h1>
        </div>
        <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="card mt-4 shadow-sm">
            <div class="alert alert-info">
                <p><strong>Horarios disponibles marcados por tu evaluador para el estándar:</strong> {{ $estandar->name }}
                    <strong>asignados al usuario:</strong>
                    {{ $usuario->name }} {{ $usuario->secondName }} {{ $usuario->paternalSurname }}
                    {{ $usuario->maternalSurname }}
                </p>
                <p><strong>con la matrícula:</strong> {{ $usuario->matricula }}</p>
            </div>
            <div class="card-body">
                @if ($fechas_competencia->isNotEmpty())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Horarios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fechas_competencia as $fecha)
                                <tr>
                                    <td>{{ $fecha->fecha->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($fecha->horarios->isNotEmpty())
                                            <ul class="list-unstyled">
                                                @foreach ($fecha->horarios as $horario)
                                                    <li>{{ $horario->hora }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">No hay horarios programados para esta fecha.</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">No hay fechas programadas para esta competencia.</p>
                @endif
            </div>
            <div class="card-footer text-center">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalFechas">
                    Elegir una fecha
                </button>
            </div>
        </div>
    </div>
    @include('expedientes.expedientesUser.evidenciasEC.fechas.show', [
        'fechas_competencia' => $fechas_competencia,
        'estandar' => $estandar,
        'usuario' => $usuario,
    ])
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
            color: #14600c;
            background-color: #a8ffb8;
            border-color: #a0f9b6;
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
