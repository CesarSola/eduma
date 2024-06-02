@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card">
        <div class="card-body-1 text-center-1">
            <p>REGISTRO A UN EC</p>
        </div>
    </div>
@stop

@section('content')
    <div class="card mb-3" style="max-width: 600px; margin: auto;">
        <div class="card-body-1 d-flex justify-content-between">
            <div class="d-flex flex-column">
                <h6 class="text-left">EC001</h6>
            </div>
            <div class="d-flex flex-column flex-grow-1 text-center">
                <h6 class="text-center">NOMBRE DEL ESTÁNDAR DE C</h6>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column mb-3">
        <div class="card mb-3" style="width: 48%; align-self: flex-start;">
            <div class="card-body">
                <h6>REQUISITOS PARA LA EVALUACIÓN Y CERTIFICACIÓN</h6>
                <h6>INFORMACIÓN DEL CURSO</h6>
                <h6>LISTA DE EVIDENCIAS</h6>
            </div>
        </div>

        <div class="d-flex justify-content-between" style="width: 100%;">
            <div class="card mb-3" style="width: 48%;">
                <div class="card-body text-center">
                    <button class="btn btn-success">SUBIR DOCUMENTOS DE INSCRIPCIÓN</button>
                </div>
            </div>
            <div class="card mb-3" style="width: 48%;">
                <div class="card-body text-center">
                    <button class="btn btn-success">SUBIR COMPROBANTE DE PAGO</button>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <button class="btn btn-success">EVIDENCIAS</button>
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
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
