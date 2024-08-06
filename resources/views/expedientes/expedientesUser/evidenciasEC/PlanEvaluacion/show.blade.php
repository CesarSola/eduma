@extends('adminlte::page')

@section('title', 'Subir Plan de Evaluación')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">Subir Plan de Evaluación</h1>
        </div>
        <a href="{{ route('evidenciasEC.index', ['id' => $estandar->id, 'name' => $estandar->name]) }}"
            class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="card">
            <div class="card-header bg-success text-white text-center font-weight-bold">
                <h3>Plan de Evaluación</h3>
            </div>
            <div class="card-body">
                <!-- Mensaje de éxito (opcional) -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulario para subir el plan de evaluación -->
                <form action="{{ route('plan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="estandar_id" value="{{ $estandar->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="form-group mt-2">
                        <label for="nombre">Nombre del Documento:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="Plan_Evaluación_{{ $estandar->name }}_{{ auth()->user()->matricula }}_{{ auth()->user()->name }}_{{ auth()->user()->secondName }}_{{ auth()->user()->paternalSurname }}_{{ auth()->user()->maternalSurname }}"
                            readonly>
                        <small class="form-text text-muted">Asegúrate de firmar tu plan de Evaluación.</small>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-2">
                        <label for="file">Selecciona el Documento (PDF):</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".pdf"
                            required>
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF.</small>
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Subir Plan de Evaluación</button>
                </form>

            </div>
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

        .card-header {
            border-bottom: 2px solid #33b300;
            background-color: #33b300;
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 1.25rem;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            padding: 10px;
            border-radius: 5px;
        }

        .btn-sm {
            font-size: 0.8em;
            padding: 0.25em 0.5em;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }
    </style>
@stop

@section('js')
@stop
