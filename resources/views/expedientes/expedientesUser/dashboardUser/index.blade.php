@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="header-flex">
        <h1>Revisión de Documentos Generales</h1>
        <div>
            <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $registroGeneral->id]) }}"
                class="btn btn-secondary">Regresar</a>
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
                                            <h6 class="text-left mt-2">Nombres: {{ $registroGeneral->name }}
                                                {{ $registroGeneral->secondName }}</h6>
                                            <h6 class="text-left mt-2">Apellidos: {{ $registroGeneral->paternalSurname }}
                                                {{ $registroGeneral->maternalSurname }}</h6>
                                            <h6 class="text-left mt-2">Edad: {{ $registroGeneral->age }} años</h6>
                                        </div>
                                        <div class="right-content">
                                            <span class="badge badge-info">Estatus: Activo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('registroGeneral.updateDocumentos', ['id' => $registroGeneral->id]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')

                            @php
                                $documentosParaRevisar = false;
                            @endphp

                            @foreach ($documentos as $documento)
                                @foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre)
                                    @if ($documento->$documentoNombre)
                                        @php
                                            $documentosParaRevisar = true;
                                            $estadoArray = json_decode($documento->estado, true);
                                            $estado = $estadoArray[$documentoNombre] ?? null;
                                        @endphp
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-2 col-form-label">{{ ucfirst(str_replace('_', ' ', $documentoNombre)) }}</label>
                                            <div class="col-sm-4">
                                                <a href="{{ Storage::url($documento->$documentoNombre) }}" target="_blank"
                                                    class="btn btn-primary">Ver</a>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="documento_{{ $documentoNombre }}"
                                                        id="validar_{{ $documentoNombre }}" value="validar"
                                                        {{ $estado === 'validar' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="validar_{{ $documentoNombre }}">Validar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="documento_{{ $documentoNombre }}"
                                                        id="rechazar_{{ $documentoNombre }}" value="rechazar"
                                                        {{ $estado === 'rechazar' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="rechazar_{{ $documentoNombre }}">Rechazar</label>
                                                </div>
                                                <textarea class="form-control mt-2" name="comentario_{{ $documentoNombre }}" placeholder="Agregar comentarios"></textarea>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach

                            @if ($comprobantePago)
                                @php
                                    $documentosParaRevisar = true;
                                    $estadoArray = json_decode($comprobantePago->estado, true);
                                    $estado = $estadoArray['comprobante_pago'] ?? null;
                                @endphp
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Comprobante de Pago</label>
                                    <div class="col-sm-4">
                                        <a href="{{ Storage::url($comprobantePago->comprobante_pago) }}" target="_blank"
                                            class="btn btn-primary">Ver</a>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="comprobante_pago"
                                                id="validar_comprobante_pago" value="validar"
                                                {{ $estado === 'validar' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="validar_comprobante_pago">Validar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="comprobante_pago"
                                                id="rechazar_comprobante_pago" value="rechazar"
                                                {{ $estado === 'rechazar' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rechazar_comprobante_pago">Rechazar</label>
                                        </div>
                                        <textarea class="form-control mt-2" name="comentario_comprobante_pago" placeholder="Agregar comentarios"></textarea>
                                    </div>
                                </div>
                            @endif

                            @if ($documentosParaRevisar)
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary">Actualizar Documentos</button>
                                    </div>
                                </div>
                            @else
                                <p class="text-center">No hay documentos para revisar.</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
