@extends('adminlte::page')

@section('title', 'Expediente')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Expediente</h1>
        <a href="{{ route('expedientesAdmin.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body header-flex">
                    <div class="left-content">
                        <div class="text-center">
                            <img src="{{ asset('path_to_default_avatar') }}" alt="" class="img-circle">
                        </div>
                        @if ($usuario)
                            <p>Nombres: {{ $usuario->name }} {{ $usuario->secondName }}</p>
                            <p>Apellidos: {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                            <p>Edad {{ $usuario->age }} años</p>
                        @else
                            <p>No se encontraron usuarios</p>
                        @endif
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#edit">
                            Editar
                        </button>
                    </div>
                    <div class="right-content">
                        <span class="badge badge-info">Estatus: Activo</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Documentos de Registro General</h3>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <ul class="list-group flex-grow-1 overflow-auto">
                                <li class="list-group-item">Documento 1</li>
                                <li class="list-group-item">Documento 2</li>
                                <li class="list-group-item">Documento 3</li>
                                <li class="list-group-item">Documento 4</li>
                                <li class="list-group-item">Documento 5</li>
                                <li class="list-group-item">Documento 6</li>
                                <li class="list-group-item">Documento 7</li>
                                <li class="list-group-item">Documento 8</li>
                                <li class="list-group-item">Documento 9</li>
                            </ul>
                            <a href="{{ route('registroGeneral.index') }}"
                                class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row h-100">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title">Competencias</h3>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <ul class="list-group flex-grow-1 overflow-auto">
                                        <li class="list-group-item">Competencia 1</li>
                                        <li class="list-group-item">Competencia 2</li>
                                        <li class="list-group-item">Competencia 3</li>
                                        <li class="list-group-item">Competencia 4</li>
                                        <li class="list-group-item">Competencia 5</li>
                                        <li class="list-group-item">Competencia 6</li>
                                        <li class="list-group-item">Competencia 7</li>
                                    </ul>
                                    <a href="{{ route('competencias.index') }}"
                                        class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title">Cursos</h3>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <ul class="list-group flex-grow-1 overflow-auto">
                                        <li class="list-group-item">Curso 1</li>
                                        <li class="list-group-item">Curso 2</li>
                                        <li class="list-group-item">Curso 3</li>
                                        <li class="list-group-item">Curso 4</li>
                                        <li class="list-group-item">Curso 5</li>
                                        <li class="list-group-item">Curso 6</li>
                                        <li class="list-group-item">Curso 7</li>
                                    </ul>
                                    <a href="{{ route('cursosExpediente.index') }}"
                                        class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                                </div>
                            </div>
                        </div>
                        @extends('expedientes.expedientesAdmin.usuarios.edit')
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            width: 30%;
            text-align: right;
        }

        .card-title {
            text-align: center;
            width: 100%;
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
            /* Ajusta esta altura según sea necesario */
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
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
