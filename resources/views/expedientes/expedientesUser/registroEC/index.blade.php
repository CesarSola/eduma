@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="left-content">
                <div class="text-center">
                    <p>SICE</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')


    <div class="card">
        <h6 style="text-align: center" class="card-title">Completa los siguientes pasos</h6>
        <br>
        <div class="card">
            <div class="card-body">
                <h6 class="text-center">Lista de requerimentos y documentación</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="text-center">Sube tus documentos</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h6 class="text-center">Descargar los formatos</h6>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #5cb85c;
            /* Color verde */
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #dff0d8;
            /* Fondo verde claro */
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }

        .text-center {
            color: #000;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
