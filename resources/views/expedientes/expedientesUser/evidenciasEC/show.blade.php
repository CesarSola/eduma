@extends('adminlte::page')

@section('title', 'Subir Evidencia')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded">
            <h1>Subir Evidencia para {{ $documento->name }}</h1>
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
                    <div class="form-group">
                        <label for="documento">Seleccionar Documento</label>
                        <input type="file" class="form-control @error('documento') is-invalid @enderror" id="documento"
                            name="documento">
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
    </style>
@stop

@section('js')
    <script>
        console.log("Subir Evidencia page loaded!");
    </script>
@stop
