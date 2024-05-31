@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body header-flex">
                    <div class="left-content">
                        <div class="text-center">
                            <p>SICE</p>
                        </div>
                    </div>
                </div>
            </div>
        @stop

        @section('content')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-title flex">
                            <div class="left-content">
                                <div class="card-header">
                                    <p>Bienvenidos</p>
                                </div>
                                <div class="card-body">
                                    <h5 class="card">NOMBRE DEL PARTICIPANTE</h5>
                                </div>
                                <div class="card-body">
                                    Completa los siguientes pasos
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @stop

    @section('js')
        <script>
            console.log("Hi, I'm using the Laravel-AdminLTE package!");
        </script>
    @stop
