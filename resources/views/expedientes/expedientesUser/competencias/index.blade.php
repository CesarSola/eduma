@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded" style="width: 300px;">
            <h1 style="font-size: 1.5rem; margin-bottom: 0;">Mis Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="col-md-12 mb-8">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">
                    Competencias inscritas por {{ $usuario->name }}
                </h6>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="container">
            @if ($competencias->isEmpty())
                <div class="alert alert-info" role="alert">
                    No tienes competencias inscritas.
                    <a class="btn btn-primary" href="{{ route('competenciaEC.index') }}">Ir a la pestaña de inscripción a un
                        curso</a>
                </div>
            @else
                <ul class="list-group">
                    @foreach ($competencias as $competencia)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span style="font-weight: bold; color: #333;">{{ $competencia->name }}</span> -
                                {{ $competencia->tipo }}
                                <a href="{{ route('evidenciasEC.index', ['id' => $competencia->id, 'name' => $competencia->name]) }}"
                                    class="btn btn-primary btn-sm ml-2">Ver</a>
                            </div>
                            <span class="badge badge-primary badge-pill">Inscrito</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
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

        .list-group-item {
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.125);
            margin-bottom: 5px;
        }

        .badge {
            font-size: 0.8em;
            vertical-align: middle;
        }

        .btn-sm {
            font-size: 0.8em;
            padding: 0.25em 0.5em;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hola, estoy usando el paquete Laravel-AdminLTE!");
    </script>
@stop
