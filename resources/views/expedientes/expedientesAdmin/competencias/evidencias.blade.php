@extends('adminlte::page')

@section('title', 'Evidencias Competencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Evidencias Competencias</h1>
        <a href="{{ route('competencia.index', ['user_id' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body header-flex">
                        <div class="left-content">
                            <div class="text-center">
                                <img src="{{ asset('path_to_default_avatar') }}" alt="" class="img-circle">
                            </div>
                            <h6 class="text-left mt-2">
                                Nombres: {{ $usuario->name }} {{ $usuario->secondName }}
                            </h6>
                            <h6 class="text-left mt-2">Apellidos: {{ $usuario->paternalSurname }}
                                {{ $usuario->maternalSurname }}</h6>
                            <h6 class="text-left mt-2">Edad: {{ $usuario->age }} años</h6>
                        </div>
                        <div class="right-content">
                            <span class="badge badge-info">Estatus: Activo</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Evidencias por Competencia</h3>
                    </div>
                    <div class="card-body">
                        @if ($estandares->isEmpty() || $estandares->every(fn($estandar) => $estandar->documentosnec->isEmpty()))
                            <div class="text-center">
                                <p>Por el momento este usuario no tiene ningún documento.</p>
                            </div>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre de la Evidencia</th>
                                        <th>Competencia</th>
                                        <th>Archivo Adjunto</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estandares as $estandar)
                                        @foreach ($estandar->documentosnec as $documento)
                                            @foreach ($documento->evidencias as $evidencia)
                                                <tr>
                                                    <td>{{ $evidencia->id }}</td>
                                                    <td>{{ $documento->name }}</td>
                                                    <td>{{ $estandar->name }}</td>
                                                    <td>
                                                        <a href="{{ Storage::url($evidencia->file_path) }}" target="_blank"
                                                            class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                                        <!-- Agregar más acciones si es necesario -->
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
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
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
