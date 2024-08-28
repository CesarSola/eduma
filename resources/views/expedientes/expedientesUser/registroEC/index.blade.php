@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded">
            <h1>Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="col-md-12 mb-8">
            <div class="card h-100">
                <div class="card-body">
                    <h6 class="card-title mb-0">Instrucciones</h6>
                </div>
                <div class="card-body">
                    @if ($competencias->isEmpty())
                        <h6 class="text-center">Por el momento no hay ninguna competencia disponible.</h6>
                    @else
                        @php
                            $usuario = Auth::user();
                        @endphp
                        @if ($usuario)
                            @foreach ($competencias as $competencia)
                                @php
                                    $comprobanteExistente = $usuario
                                        ->comprobantesCO()
                                        ->where('estandar_id', $competencia->id)
                                        ->first();

                                    $inscrito = $comprobanteExistente !== null;
                                    $promedio = $competencia->promedio_usuario;
                                    $calificacionMinima = $competencia->calificacion_minima;
                                    $mostrarVolverACursar =
                                        $inscrito && $promedio !== null && $promedio < $calificacionMinima;
                                @endphp
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="card-title mb-0">{{ $competencia->numero }} -
                                                    {{ $competencia->name }}
                                                    ({{ $competencia->tipo }})
                                                </h6>
                                            </div>
                                            @if ($comprobanteExistente)
                                                @if ($mostrarVolverACursar && !$competencia->comprobante_recursar_existente)
                                                    <a href="{{ route('volverACursar', ['competencia' => $competencia->id]) }}"
                                                        class="btn btn-warning">Volver a Cursar</a>
                                                @else
                                                    <span class="badge badge-success badge-pill">Inscrito</span>
                                                    <div class="card-footer">
                                                        <a href="{{ route('miscompetencias.index') }}"
                                                            class="btn btn-primary">Ir a Mis Competencias</a>
                                                    </div>
                                                @endif
                                            @else
                                                <a href="{{ route('competenciaEC.show', ['competenciaEC' => $competencia->id]) }}"
                                                    class="btn btn-primary">Inscribirse</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h6 class="text-center">Debe estar autenticado para ver las competencias.</h6>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .text-center {
            color: #000;
        }

        .text-center-1 {
            color: #fff;
            text-align: center;
        }

        .text-left {
            color: #000;
        }

        .card-title {
            font-weight: bold;
            color: #5cb85c;
        }

        .card-body {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }

        .card-footer {
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #0275d8;
            border-color: #0275d8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #025aa5;
            border-color: #025aa5;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .btn-warning {
            background-color: #f0ad4e;
            border-color: #f0ad4e;
            color: white;
        }

        .btn-warning:hover {
            background-color: #ec971f;
            border-color: #d58512;
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
