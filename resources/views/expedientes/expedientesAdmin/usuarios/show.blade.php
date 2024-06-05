@extends('adminlte::page')

@section('title', 'Expediente')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Expediente</h1>
        <a href="{{ route('usuariosAdmin.index') }}" class="btn btn-secondary">Regresar</a>
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
                        <p>Nombres: {{ $usuariosAdmin->name }} {{ $usuariosAdmin->secondName }}</p>
                        <p>Apellidos: {{ $usuariosAdmin->paternalSurname }} {{ $usuariosAdmin->maternalSurname }}</p>
                        <p>Edad {{ $usuariosAdmin->age }} años</p>
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
                            @if ($usuariosAdmin->documentos->count() > 0)
                                <ul class="list-group flex-grow-1 overflow-auto">
                                    @foreach ($usuariosAdmin->documentos as $documento)
                                        <li class="list-group-item">{{ $documento->nombre }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('registroGeneral.show', $usuariosAdmin->id) }}"
                                    class="btn btn-primary">Ver</a>
                            @else
                                <p>No hay documentos disponibles.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">Competencias</h3>
                        </div>
                        <div class="card-body d-flex flex-column">
                            @if ($usuariosAdmin->estandares->count() > 0)
                                <ul class="list-group flex-grow-1 overflow-auto">
                                    @foreach ($usuariosAdmin->competencias as $competencia)
                                        <li class="list-group-item">{{ $competencia->nombre }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('competencia.index', ['user_id' => $usuariosAdmin->id]) }}"
                                    class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                            @else
                                <p>No hay competencias disponibles.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title">Cursos</h3>
                    </div>
                    <div class="card-body d-flex flex-column">
                        @if ($usuariosAdmin->cursos->count() > 0)
                            <ul class="list-group flex-grow-1 overflow-auto">
                                @foreach ($usuariosAdmin->cursos as $curso)
                                    <li class="list-group-item">{{ $curso->nombre }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('cursosExpediente.index', ['user_id' => $usuariosAdmin->id]) }}"
                                class="btn btn-primary btn-block btn-sm mt-2">Ver</a>
                        @else
                            <p>No hay cursos disponibles.</p>
                        @endif
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
