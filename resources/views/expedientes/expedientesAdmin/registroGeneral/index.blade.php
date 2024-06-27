@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Documentos del Usuario</h1>
        <a href="{{ route('usuariosAdmin.show', $documentos->first()->user_id) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Documentos de {{ $nombreUsuario }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Documento</th>
                                    <th>Fecha de Subida</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <td>{{ $documento->id }}</td>
                                    <td>
                                        {{ basename($documento->ine_ife) }}
                                        <br>
                                        {{ basename($documento->comprobante_domiciliario) }}
                                        <br>
                                        {{ basename($documento->foto) }}
                                        <br>
                                        {{ basename($documento->curp) }}
                                    </td>
                                    <td>
                                        {{ $documento->created_at }}
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
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

        .card-title {
            background-color: #067dd2;
            text-align: center;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .list-group-item {
            text-align: center;
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .overflow-auto {
            max-height: 200px;
            /* Ajusta esta altura según sea necesario */
            overflow-y: auto;
        }

        .btn-secondary {
            margin-left: auto;
        }

        .btn-success {
            align-content: center;
            width: 50%;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop
