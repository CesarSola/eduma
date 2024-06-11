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

                            <!-- Mostrar documentos específicos -->
                            @foreach ($documentos as $documento)
                                @foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre)
                                    @if ($documento->$documentoNombre)
                                        @php
                                            $documentosParaRevisar = true;
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
                                                        id="validar_{{ $documentoNombre }}" value="validar">
                                                    <label class="form-check-label"
                                                        for="validar_{{ $documentoNombre }}">Validar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="documento_{{ $documentoNombre }}"
                                                        id="rechazar_{{ $documentoNombre }}" value="rechazar">
                                                    <label class="form-check-label"
                                                        for="rechazar_{{ $documentoNombre }}">Rechazar</label>
                                                </div>
                                                <textarea class="form-control mt-2" name="comentario_{{ $documentoNombre }}" placeholder="Agregar comentarios"></textarea>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endforeach

                            <!-- Mostrar comprobante de pago -->
                            @if ($comprobantePago)
                                @php
                                    $documentosParaRevisar = true;
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
                                                id="validar_comprobante_pago" value="validar">
                                            <label class="form-check-label" for="validar_comprobante_pago">Validar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="comprobante_pago"
                                                id="rechazar_comprobante_pago" value="rechazar">
                                            <label class="form-check-label" for="rechazar_comprobante_pago">Rechazar</label>
                                        </div>
                                        <textarea class="form-control mt-2" name="comentario_comprobante_pago" placeholder="Agregar comentarios"></textarea>
                                    </div>
                                </div>
                            @endif

                            @if ($documentosParaRevisar)
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </div>
                                </div>
                            @else
                                <div class="form-group row">
                                    <div class="col-sm-12 text-center">
                                        <p>Todos los documentos disponibles han sido validados.</p>
                                    </div>
                                </div>
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
