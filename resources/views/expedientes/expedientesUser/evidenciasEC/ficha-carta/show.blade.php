@extends('adminlte::page')

@section('title', 'Subir Documentos')

@section('content_header')
    <h1>Subir Ficha de Registro y Carta de Firma</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                @if ($tipoDocumento === 'ficha_registro')
                    <form action="{{ route('word.uploadFichaRegistro', ['id' => $estandar->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="ficha_registro" class="form-label">Ficha de Registro</label>
                            <input type="file" class="form-control" id="ficha_registro" name="ficha_registro" required>
                        </div>
                        <button type="submit" class="btn btn-success">Subir Ficha de Registro</button>
                    </form>
                @elseif ($tipoDocumento === 'carta_firma')
                    <form action="{{ route('word.uploadCartaFirma', ['id' => $estandar->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="carta_firma" class="form-label">Carta de Firma</label>
                            <input type="file" class="form-control" id="carta_firma" name="carta_firma" required>
                        </div>
                        <button type="submit" class="btn btn-success">Subir Carta de Firma</button>
                    </form>
                @endif
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
    </style>
@stop
