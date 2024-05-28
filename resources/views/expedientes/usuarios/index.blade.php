@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="header-flex">
        <h1>EXPEDIENTE</h1>
        <div>
            <form action="{{ route('expedientes.index') }}" method="GET">
                <button type="submit" class="btn btn-primary">regresar</button>
            </form>
        </div>
    </div>
@stop

@section('content')
    <div class="content-flex">
        <div class="left-content">
            <p>Documentos de Registro General</p>
            <form action="{{ route('registroGeneral.index') }}" method="GET">
                <button type="submit" class="btn btn-primary">Ver Documentos</button>
            </form>
        </div>
        <div class="right-content">
            <p>Competencias</p>
            <form action="{{ route('competencias.index') }}" method="GET">
                <button type="submit" class="btn btn-primary">Ver Competencias</button>
            </form>
            <p>Cursos</p>
            <form action="{{ route('cursos.index') }}" method="GET">
                <button type="submit" class="btn btn-primary">Ver Cursos</button>
            </form>
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

        .content-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .left-content {
            width: 50%;
            float: left;
        }

        .right-content {
            width: 50%;
            float: right;
            text-align: right;
        }

        .button-right {
            float: right;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
