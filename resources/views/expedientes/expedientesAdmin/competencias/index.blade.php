@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Competencias</h1>
        <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
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
                        <p>Nombres: {{ $usuario->name }} {{ $usuario->secondName }}</p>
                        <p>Apellidos: {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                        <p>Edad: {{ $usuario->age }} años</p>
                    </div>
                    <div class="right-content">
                        <!-- Mostrar el estatus de la competencia -->
                        @foreach ($competencias as $competencia)
                            <span class="badge badge-info">Estatus:
                                @php
                                    $comprobanteValidado = false;

                                    // Verificar si hay comprobantes de competencias y procesarlos
                                    if ($competencia->comprobantesCO) {
                                        foreach ($competencia->comprobantesCO as $comprobante) {
                                            // Asegurarnos de que $comprobante es un objeto
                                            if (is_object($comprobante)) {
                                                $estado = json_decode($comprobante->estado, true);
                                                if (
                                                    isset($estado['validacion_comprobante_pago']) &&
                                                    $estado['validacion_comprobante_pago'] === 'validar'
                                                ) {
                                                    $comprobanteValidado = true;
                                                    break; // Salir del bucle una vez encontrado un comprobante validado
                                                }
                                            }
                                        }
                                    }
                                @endphp

                                @if ($comprobanteValidado)
                                    Activo
                                @else
                                    Inactivo
                                @endif
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia)
                        <tr>
                            <td>{{ $competencia->id }}</td>
                            <td>{{ $competencia->name }}</td>
                            <td>{{ $competencia->tipo }}</td>
                            <td>
                                <a href="{{ route('evidenciasACO.index', ['competencia' => $competencia->id, 'user_id' => $usuario->id]) }}"
                                    class="btn btn-primary">Ver Evidencias</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Competencias</th>
                        <th>Fechas Asignadas</th>
                        <th>Agregar Fechas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia)
                        <tr>
                            <td>{{ $competencia->id }}</td>
                            <td>{{ $competencia->name }}</td>
                            <td>
                                <ul>
                                    @foreach ($competencia->fechas as $fecha)
                                        <li>{{ $fecha->fecha }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="{{ route('competencias.agregar-fechas', ['competencia' => $competencia->id]) }}"
                                    class="btn btn-primary">Agregar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('css')
    <style>
        .card-title {
            background-color: #067dd2;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .right-content {
            text-align: right;
        }

        .right-content div {
            margin-bottom: 5px;
            /* Espacio entre cada badge */
        }

        .text-center {
            color: #000000;
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
