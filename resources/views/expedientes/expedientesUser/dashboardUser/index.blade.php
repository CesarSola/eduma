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
        <div class="card-body">
            <div class="card-header">
                <h4>Bienvenido</h4>
                <div class="card-title">
                    <h6 class="text">
                        {{ $usuario->name }}
                        {{ $usuario->secondName }}
                        {{ $usuario->paternalSurname }}
                        {{ $usuario->maternalSurname }}
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <h6 style="text-align: center" class="card-title toggle-card" data-target="#requerimientos">Lista de requerimientos
            y documentación</h6>
        <br>
        <div class="card d-none" id="requerimientos">
            <div class="card-body">
                <h6 class="text-center">Contenido de requerimientos y documentación...</h6>
            </div>
        </div>
    </div>
    <div class="card">
        <h6 style="text-align: center" class="card-title toggle-card" data-target="#documentos">Sube tus documentos</h6>
        <br>
        <div class="card d-none" id="documentos">
            <div class="card-body">
                <h6 class="text-center">Contenido de sube tus documentos...</h6>
            </div>
        </div>
    </div>
    <div class="card">
        <h6 style="text-align: center" class="card-title toggle-card" data-target="#formatos">Descargar los formatos</h6>
        <br>
        <div class="card d-none" id="formatos">
            <div class="card-body">
                <h6 class="text-center">Contenido de descargar los formatos...</h6>
            </div>
        </div>
    </div>

    <br>
    <div class="card">
        <h6 style="text-align: center" class="card-title">Regístrate a la evaluación de un EC</h6>
        <br>
        @foreach ($competencias as $competencia)
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column align-items-start">
                        <h6 class="text-left">{{ $competencia->numero }}</h6>
                    </div>
                    <div class="d-flex flex-column align-items-center flex-grow-1">
                        <h6 class="text-center">{{ $competencia->name }}</h6>
                    </div>
                    <div class="d-flex">
                        <a class="btn btn-primary" href="{{ route('registroEC.index') }}">Regístrate</a>
                        <a class="btn btn-danger" href="#">Descargar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <br>
    <div class="card">
        <h6 style="text-align: center" class="card-title">Cursos</h6>
        <br>
        <div class="card">
            <div class="card-body">
                <ul>
                    @foreach ($cursos as $curso)
                        <li>{{ $curso->name }} {{ $curso->description }} {{ $curso->competencia }}</li>
                    @endforeach
                </ul>
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

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleCards = document.querySelectorAll('.toggle-card');

            toggleCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const target = document.querySelector(targetId);
                    target.classList.toggle('d-none');
                });
            });
        });
    </script>
@stop
