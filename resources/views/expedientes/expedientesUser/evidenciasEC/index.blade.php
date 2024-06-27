@extends('adminlte::page')

@section('title', 'Evidencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">{{ $estandar->name }}</h1>
        </div>
        <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container mt-4">
        @if ($documentos->isEmpty())
            <div class="alert alert-info shadow-sm" role="alert">
                No hay documentos necesarios para este estándar.
            </div>
        @else
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary font-weight-bold">Documentos Necesarios Como Evidencias para este EC
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documentos as $documento)
                                    <tr>
                                        <td>{{ $documento->name }}</td>
                                        <td>{{ $documento->description }}</td>
                                        <td>
                                            <a href="{{ Storage::url($documento->documento) }}" target="_blank"
                                                class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                            @if (!in_array($documento->id, $uploadedDocumentIds))
                                                <a href="{{ route('evidenciasEC.show', ['id' => $estandar->id, 'documento' => $documento->id]) }}"
                                                    class="btn btn-success btn-sm shadow-sm">Subir</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if ($evidencias->isNotEmpty())
            <div class="card mt-4 shadow-sm">
                <div class="card-body">
                    <h6 class="card-title text-primary font-weight-bold">Evidencias Subidas</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Documento</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($evidencias as $evidencia)
                                    <tr>
                                        <td>{{ $evidencia->documento->name }}</td>
                                        <td></td>
                                        <td>
                                            <a href="{{ Storage::url($evidencia->file_path) }}" target="_blank"
                                                class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        .card {
            background-color: #f9f9f9;
            border: 1px solid #24b83a;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            padding: 10px;
            border-radius: 5px;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #007302;
            background-color: #fff;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .btn-sm {
            font-size: 0.8em;
            padding: 0.25em 0.5em;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        .thead-dark th {
            color: #fff;
            background-color: #00366d;
            border-color: #454d55;
        }

        .text-primary {
            color: #007bff !important;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Evidencias page loaded!");
    </script>
@stop
