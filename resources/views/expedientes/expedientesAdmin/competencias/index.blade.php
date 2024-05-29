@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="header-flex">
        <h1>Competencias</h1>
        <div>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body header-flex">
                                        <div class="left-content">
                                            <div class="text-center">
                                                <img src="{{ asset('path_to_default_avatar') }}" alt=""
                                                    class="img-circle">
                                            </div>
                                            <h6 class="text-left mt-2">Nombre</h6>
                                            <h6 class="text-left mt-2">Apellido</h6>
                                            <h6 class="text-left mt-2">Edad: 30 años</h6>
                                            <!-- Button trigger modal -->
                                        </div>
                                        <div class="right-content">
                                            <span class="badge badge-info">Estatus: Activo</span>
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
                        {{-- Add here extra stylesheets --}}
                        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
                    @stop

                    @section('js')
                        <script>
                            console.log("Hi, I'm using the Laravel-AdminLTE package!");
                        </script>
                    @stop
