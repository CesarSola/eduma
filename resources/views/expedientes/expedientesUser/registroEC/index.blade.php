@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="card-body-1 text-center-1">
            <h1>Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        @foreach ($competencias as $competencia)
            <div class="card mb-3" style="max-width: 600px; margin: auto;">
                <div class="card-body-1 d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column text-center">
                        <h6>{{ $competencia->numero }} {{ $competencia->name }} {{ $competencia->tipo }}</h6>
                        <a href="{{ route('competenciaEC.show', ['id' => $competencia->id]) }}"
                            class="btn btn-primary">Seleccionar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #5cb85c;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #dff0d8;
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }

        .card-body-1 {
            background-color: #5cb85c;
            padding: 10px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
            color: #fff;
            text-align: center;
        }

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

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .btn-success {
            background-color: #5cb85c;
            border-color: #5cb85c;
            color: white;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
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
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
