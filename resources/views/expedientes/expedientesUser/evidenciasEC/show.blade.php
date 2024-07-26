@extends('adminlte::page')

@section('title', 'Subir Evidencia')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded">
            <h1>Subir Evidencia para el estándar {{ $estandar->name }}</h1>
        </div>
        <a href="{{ route('evidenciasEC.index', ['id' => $estandar->id, 'name' => $estandar->name]) }}"
            class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('evidenciasEC.upload', $documento->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Campo oculto para pasar el ID del estándar -->
                    <input type="hidden" name="estandar_id" value="{{ $estandar->id }}">

                    <div class="form-group">
                        <div class="alert alert-info">
                            <p><strong>Nombre del documento:</strong> {{ $documento->name }}</p>
                        </div>
                        <label for="documento">Seleccionar Documento</label>
                        <input type="file" class="form-control-file @error('documento') is-invalid @enderror"
                            id="documento" name="documento" accept=".pdf">
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF para poder
                            subirlo.</small>
                        @error('documento')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Subir</button>
                </form>
            </div>
        </div>
    </div>
@stop


@section('css')
    <style>
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-primary {
            margin-top: 10px;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            padding: 10px;
            border-radius: 5px;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: .375rem;
            /* Bordes redondeados */
            font-size: 1rem;
            /* Tamaño de fuente */
        }

        /* Texto centrado */
        .alert p {
            margin-bottom: 0;
            text-align: center;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Subir Evidencia page loaded!");
    </script>
@stop
