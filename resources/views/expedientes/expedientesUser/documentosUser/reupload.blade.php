<!-- resources/views/expedientes/expedientesUser/documentosUser/reupload.blade.php -->

@extends('adminlte::page')

@section('title', 'Re-subir Documento')

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Re-subir {{ ucfirst(str_replace('_', ' ', $tipo_documento)) }}</h4>
            <form action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="tipo_documento" value="{{ $tipo_documento }}">
                <div class="form-group">
                    <label for="documento">{{ ucfirst(str_replace('_', ' ', $tipo_documento)) }}</label>
                    <input type="file" name="{{ $tipo_documento }}" id="documento" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Subir</button>
            </form>
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

        .card-body {
            background-color: #dff0d8;
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }
    </style>
@stop
