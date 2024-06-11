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
                <ul>
                    @if ($documentos->isEmpty())
                        <h6 class="text-center"><span>Para continuar con el proceso sube estos documentos: </span></h6>
                        <br>
                        <li><span>Fotografía digital: tamaño infantil 2.5 cm x 3 cm (94.50 x 113.4 pixeles) de frente A
                                color con fondo blanco, Sin sombras y sin lentes, Con peso máximo de 300 Kb y formato
                                JPG,
                                BMP o PNG. Debido a que esta fotografía servirá para el certificado oficial se
                                recomienda
                                acudir a un estudio fotográfico.</span></li>
                        <br>
                        <li><span>Identificación oficial escaneada INE o IFE Que sea legible</span></li>
                        <br>
                        <li><span>Comprobante Domiciliario Actual y escaneado de forma legible en PDF</span></li>
                        <br>
                        <li><span>CURP en formato PDF Escaneado y legible</span></li>
                    @else
                        <h6 class="text-center">Los documentos aún no han sido subidos.</h6>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    @if ($documentos->isEmpty())
        <!-- Mostrar formulario para subir documentos si no se han subido -->
        <a href="{{ route('documentosUser.index') }}" class="btn btn-primary">Subir documentos</a>
    @else
        <!-- Mostrar comentarios y validaciones de documentos si se han subido -->
        <div class="card">
            <h6 style="text-align: center" class="card-title toggle-card" data-target="#comentarios">Comentarios y
                Validaciones</h6>
            <div class="card d-none" id="comentarios">
                <div class="card-body">
                    <!-- Mostrar comentarios y validaciones de documentos -->
                    @php
                        $someDocumentNotValidated = false;
                        foreach ($documentos as $documento) {
                            foreach ($documento->validacionesComentarios as $validacion) {
                                if (!$validacion->tipo_validacion) {
                                    $someDocumentNotValidated = true;
                                    break 2; // Salir del bucle foreach
                                }
                            }
                        }
                    @endphp

                    @if ($someDocumentNotValidated)
                        <!-- Mostrar el botón para subir documentos -->
                        <a href="{{ route('documentosUser.index') }}" class="btn btn-primary">Subir documentos</a>
                    @endif

                    <!-- Mostrar los comentarios y validaciones -->
                    @foreach ($documentos as $documento)
                        @foreach ($documento->validacionesComentarios as $validacion)
                            <p><strong>{{ ucfirst(str_replace('_', ' ', $validacion->tipo_documento)) }}:</strong>
                                {{ $validacion->comentario }}</p>
                            <p><strong>Validado:</strong> {{ $validacion->tipo_validacion ? 'Sí' : 'No' }}</p>
                        @endforeach
                    @endforeach

                    <!-- Mostrar comentarios y validaciones del comprobante de pago -->
                    @foreach ($comprobantes as $comprobante)
                        @foreach ($comprobante->validacionesComentarios as $validacion)
                            <p><strong>{{ ucfirst(str_replace('_', ' ', $validacion->tipo_documento)) }}:</strong>
                                {{ $validacion->comentario }}</p>
                            <p><strong>Validado:</strong> {{ $validacion->tipo_validacion ? 'Sí' : 'No' }}</p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    @endif


    @if ($documentos->isNotEmpty())
        <div class="card">
            <h6 style="text-align: center" class="card-title">Regístrate a la evaluación de un EC</h6>
            <br>
            @foreach ($competencias as $competencia)
                @php
                    $comprobante = $comprobantes->firstWhere('estandar_id', $competencia->id);
                @endphp
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex flex-column align-items-start">
                            <h6 class="text-left">{{ $competencia->numero }}</h6>
                        </div>
                        <div class="d-flex flex-column align-items-center flex-grow-1">
                            <h6 class="text-center">{{ $competencia->name }}</h6>
                        </div>
                        <div class="d-flex">
                            @if ($comprobante)
                                <a class="btn btn-primary"
                                    href="{{ route('competenciaEC.index', ['id' => $competencia->id]) }}">Ver</a>
                            @else
                                <a class="btn btn-primary"
                                    href="{{ route('competenciaEC.index', ['id' => $competencia->id]) }}">Regístrate</a>
                            @endif
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
    @endif

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
                const targetId = card.getAttribute('data-target');
                const target = document.querySelector(targetId);

                // Load the state from localStorage
                const state = localStorage.getItem(targetId);
                if (state === 'open') {
                    target.classList.remove('d-none');
                } else {
                    target.classList.add('d-none');
                }

                card.addEventListener('click', function() {
                    target.classList.toggle('d-none');
                    // Save the state to localStorage
                    if (target.classList.contains('d-none')) {
                        localStorage.setItem(targetId, 'closed');
                    } else {
                        localStorage.setItem(targetId, 'open');
                    }
                });
            });
        });
    </script>
@stop
