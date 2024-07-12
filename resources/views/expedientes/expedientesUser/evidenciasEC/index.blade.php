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
        <div class="card">
            <div class="card-body text-center">
                {{-- Mostrar solo si la ficha de registro no ha sido subida --}}
                @if (!$ficha_registro)
                    <div class="card">
                        <form id="form-ficha-registro"
                            action="{{ route('generate-word', ['userId' => Auth::id(), 'standardId' => $estandar->id]) }}"
                            method="GET">
                            @csrf
                            <div class="mb-3">
                                <h6 class="card-title text-primary font-weight-bold">Descarga la Ficha de Inscripción</h6>
                                <button type="submit" class="btn btn-success btn-sm shadow-sm mt-3">Descargar
                                    Ficha</button>
                            </div>
                        </form>
                @endif

                {{-- Mostrar solo si la carta de firma digital no ha sido subida --}}
                @if (!$carta_firma)
                    <form id="form-carta-aceptacion" action="{{ route('generate-carta', ['userId' => Auth::id()]) }}"
                        method="GET">
                        @csrf
                        <div class="mb-3">
                            <h6 class="card-title text-primary font-weight-bold">Descarga la Carta de Firma Digital</h6>
                            <button type="submit" class="btn btn-success btn-sm shadow-sm mt-3">Descargar
                                Carta</button>
                        </div>
                    </form>
                @endif
            </div>

            {{-- Mostrar la sección de subida de documentos solo si ambos documentos no han sido subidos --}}
            @if (!$ficha_registro || !$carta_firma)
                <div class="container mt-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- Botón para subir la ficha --}}
                            <div class="mb-3">
                                <h6 class="card-title text-primary font-weight-bold">Sube tu ficha de registro,
                                    verificando que los datos sean correctos y ya firmada</h6>
                                @if ($ficha_registro)
                                    <p>Ya has subido la ficha de registro.</p>
                                @else
                                    <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'ficha_registro']) }}"
                                        class="btn btn-success btn-sm shadow-sm">Subir ficha</a>
                                @endif
                            </div>
                            {{-- Botón para subir la carta de aceptación --}}
                            <div class="mb-3">
                                <h6 class="card-title text-primary font-weight-bold">Sube tu carta de de Firma Digital,
                                    leyendo detalladamente y ya firmada</h6>
                                @if ($carta_firma)
                                    <p>Ya has subido la carta de firma digital.</p>
                                @else
                                    <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'carta_firma']) }}"
                                        class="btn btn-success btn-sm shadow-sm">Subir carta</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Verifica si ficha_registro y carta_firma están vacíos --}}
            @if ($ficha_registro && $carta_firma)
                @if ($evidencias->isNotEmpty())
                    <div class="card mt-4 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title text-primary font-weight-bold">Evidencias Para Subir</h6>
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
                                        @if (!$documentos->isEmpty())
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
                                        @else
                                            <tr>
                                                <td colspan="3">No hay documentos necesarios para este estándar.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Mostrar evidencias subidas solo si ambos documentos han sido subidos --}}
                @if ($ficha_registro && $carta_firma)
                    {{-- Verificar si hay evidencias válidas --}}
                    @php
                        $hayEvidenciasValidas = false;
                        foreach ($evidencias as $evidencia) {
                            if ($evidencia->documento_id) {
                                $hayEvidenciasValidas = true;
                                break;
                            }
                        }
                    @endphp

                    @if ($hayEvidenciasValidas)
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
                                                {{-- Filtrar para mostrar solo documentos válidos --}}
                                                @if ($evidencia->documento_id)
                                                    <tr>
                                                        <td>{{ optional($evidencia->documento)->name }}</td>
                                                        <td>{{ $evidencia->estado }}</td>
                                                        <td>
                                                            <a href="{{ Storage::url($evidencia->file_path) }}"
                                                                target="_blank"
                                                                class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info shadow-sm mt-4" role="alert">
                            Aún no tienes evidencias subidas, sube tus evidencias para su respectiva revisión y aprobación.
                        </div>
                    @endif
                @endif
            @else
                <div class="alert alert-info shadow-sm mt-4" role="alert">
                    Sube tanto la ficha de registro como la carta de tu firma digital, para ver la sección de los documentos
                    necesarios
                    que tienes que subir para este EC.
                </div>
            @endif
        </div>
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
        // Puedes agregar scripts aquí si es necesario
    </script>
@stop
