@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <h1>Expediente</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Datos Personales</h3>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('path_to_default_avatar') }}" alt="User Avatar" class="img-circle">
                    </div>
                    <h4 class="text-center mt-2">Nombre | Apellido</h4>
                    <p class="text-muted text-center">Datos Personales</p>
                    <a href="#" class="btn btn-success btn-block">Editar</a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expediente</h3>
                    <div class="card-tools">
                        <span class="badge badge-info">Estatus: Activo</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Documentos de Registro General</h4>
                            <ul class="list-group">
                                <li class="list-group-item">Documento 1</li>
                                <li class="list-group-item">Documento 2</li>
                                <li class="list-group-item">Documento 3</li>
                                <li class="list-group-item">Documento 4</li>
                            </ul>
                            <a href="{{ route('registroGeneral.index') }}" class="btn btn-primary btn-block mt-2">Ver</a>
                        </div>
                        <div class="col-md-6">
                            <h4>Competencias | Cursos</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">Competencia 1</li>
                                        <li class="list-group-item">Competencia 2</li>
                                        <li class="list-group-item">Competencia 3</li>
                                    </ul>
                                    <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-block mt-2">Ver</a>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group">
                                        <li class="list-group-item">Curso 1</li>
                                        <li class="list-group-item">Curso 2</li>
                                        <li class="list-group-item">Curso 3</li>
                                    </ul>
                                    <a href="{{ route('competencias.index') }}"
                                        class="btn btn-primary btn-block mt-2">Ver</a>
                                </div>
                            </div>

                        </div>
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
