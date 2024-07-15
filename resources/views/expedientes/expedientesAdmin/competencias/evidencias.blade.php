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
                        @if ($evidencias->isEmpty())
                            <div class="text-center">
                                <p>Por el momento este usuario no tiene ninguna evidencia de competencias.</p>
                            </div>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre del Documento</th>
                                        <th>Competencia</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($evidencias as $evidencia)
                                        @if ($evidencia->documento_id)
                                            <tr>
                                                <td>{{ $evidencia->id }}</td>
                                                <td>{{ $evidencia->documento->name ?? 'Documento no disponible' }}</td>
                                                <td>{{ $evidencia->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($evidencia->file_path) }}" target="_blank"
                                                        class="btn btn-primary btn-sm shadow-sm">Ver Archivo</a>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($evidencia->ficha_registro_path)
                                            <tr>
                                                <td>{{ $evidencia->id }}</td>
                                                <td>Ficha de Registro</td>
                                                <td>{{ $evidencia->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($evidencia->ficha_registro_path) }}"
                                                        target="_blank" class="btn btn-info btn-sm shadow-sm">Ver Ficha</a>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($evidencia->carta_firma_path)
                                            <tr>
                                                <td>{{ $evidencia->id }}</td>
                                                <td>Carta de Firma</td>
                                                <td>{{ $evidencia->estandar->name ?? 'Competencia no disponible' }}</td>
                                                <td>
                                                    <a href="{{ Storage::url($evidencia->carta_firma_path) }}"
                                                        target="_blank" class="btn btn-info btn-sm shadow-sm">Ver Carta</a>
                                                </td>
                                            </tr>
                                        @endif
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
