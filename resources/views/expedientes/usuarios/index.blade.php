@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <h1>Expediente</h1>
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
                        <h6 class="text-left mt-2">Nombre</h6>
                        <h6 class="text-left mt-2">Apellido</h6>
                        <h6 class="text-left mt-2">Edad: 30 años</h6>

                        <a href="#" class="btn btn-success btn-block">Editar</a>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Documentos de Registro General</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Documento 1</li>
                                <li class="list-group-item">Documento 2</li>
                                <li class="list-group-item">Documento 3</li>
                                <li class="list-group-item">Documento 4</li>
                            </ul>
                            <a href="{{ route('registroGeneral.index') }}" class="btn btn-primary btn-block mt-2">Ver</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Competencias</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">Competencia 1</li>
                                        <li class="list-group-item">Competencia 2</li>
                                        <li class="list-group-item">Competencia 3</li>
                                    </ul>
                                    <a href="{{ route('competencias.index') }}"
                                        class="btn btn-primary btn-block mt-2">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Cursos</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">Curso 1</li>
                                        <li class="list-group-item">Curso 2</li>
                                        <li class="list-group-item">Curso 3</li>
                                    </ul>
                                    <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-block mt-2">Ver</a>
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

        .left-content {
            width: 70%;
        }

        .right-content {
            width: 30%;
            text-align: right;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
