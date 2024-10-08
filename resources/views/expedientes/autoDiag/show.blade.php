@extends('adminlte::page')

@section('title', 'Detalles del Autodiagnóstico')

@section('content_header')
    <h1 class="text-center">Detalles del Autodiagnóstico</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Información del Autodiagnóstico</h5>
            </div>
            <div class="card-body">
                <h2>Nombre del Autodiagnóstico: <strong>{{ $diagnostico->titulo }}</strong></h2>
                <h3><strong>Estandar:</strong> {{ $diagnostico->estandar->numero ?? 'No disponible' }}</h3>
                <h3><strong>Descripción: </strong> {{ $diagnostico->descripcion }}</h3>
                <h3><strong>Número de Elementos: </strong> {{ $elementos->count() }}</h3>

                <h3>Nombres de Elementos:</h3>
                <ul class="list-group">
                    @if ($elementos->isNotEmpty())
                        @foreach ($elementos as $elemento)
                            <li class="list-group-item">
                                <strong>{{ $elemento->nombre }}</strong>
                                <ul>
                                    @if ($elemento->criterios->isNotEmpty())
                                        @foreach ($elemento->criterios as $criterio)
                                            <li>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <span>{{ $criterio->nombre }}</span>
                                                    <!-- Botón para agregar nueva pregunta -->
                                                    <button class="btn btn-primary me-2" data-bs-target="#addPreguntaModal"
                                                        data-bs-toggle="modal" data-elemento="{{ $elemento->nombre }}"
                                                        data-criterio="{{ $criterio->nombre }}"
                                                        data-elemento-id="{{ $elemento->id }}"
                                                        data-criterio-id="{{ $criterio->id }}">
                                                        Agregar Pregunta
                                                    </button>
                                                </div>
                                                <ul>
                                                    @if ($criterio->preguntas->isNotEmpty())
                                                        @foreach ($criterio->preguntas as $pregunta)
                                                            <li class="d-flex justify-content-between align-items-center">
                                                                <span>{{ $pregunta->pregunta }}</span>
                                                                <!-- Botón para editar la pregunta -->
                                                                <button class="btn btn-warning me-2"
                                                                    data-bs-target="#editPreguntaModal"
                                                                    data-bs-toggle="modal"
                                                                    data-elemento="{{ $elemento->nombre }}"
                                                                    data-criterio="{{ $criterio->nombre }}"
                                                                    data-elemento-id="{{ $elemento->id }}"
                                                                    data-criterio-id="{{ $criterio->id }}"
                                                                    data-id="{{ $pregunta->id }}"
                                                                    data-autodiagnostico-id="{{ $diagnostico->id }}">
                                                                    Editar Pregunta
                                                                </button>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <li>No hay preguntas asociadas</li>
                                                    @endif
                                                </ul>
                                            </li>
                                        @endforeach
                                    @else
                                        <li>No hay criterios asociados</li>
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    @else
                        <li>No hay elementos asociados</li>
                    @endif
                </ul>


                <a href="{{ route('autodiagnosticos.index') }}" class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>

    @include('expedientes.autoDiag.preguntas.create') <!-- Incluimos el modal aquí -->
    @include('expedientes.autoDiag.preguntas.edit') <!-- Incluimos el modal aquí -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Estilo personalizado */
        body {
            background-color: #f8f9fa;
            /* Color de fondo claro */
        }

        .card {
            border: 1px solid #007bff;
            /* Borde azul */
            border-radius: 0.5rem;
            /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Sombra para profundidad */
        }

        .card-header {
            background-color: #007bff;
            /* Fondo azul para el encabezado */
            color: white;
            /* Texto blanco en el encabezado */
        }

        .table-success {
            background-color: #e2f0d9;
            /* Fondo verde claro para el encabezado de la tabla */
        }

        .btn-success {
            background-color: #28a745;
            /* Color verde para el botón "Ver" */
            border-color: #28a745;
            /* Borde verde para el botón "Ver" */
        }

        .btn-success:hover {
            background-color: #218838;
            /* Color verde más oscuro al pasar el mouse */
            border-color: #1e7e34;
            /* Borde más oscuro al pasar el mouse */
        }
    </style>
@stop
@section('js')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stop
