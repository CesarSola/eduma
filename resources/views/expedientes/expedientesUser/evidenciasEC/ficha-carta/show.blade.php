@extends('adminlte::page')

@section('title', 'Subir Documentos')

@section('content_header')
    <h1 class="text-center text-success">Subir Ficha de Registro y Carta de Firma</h1>
@stop

@section('content')
    <div class="container mt-4">
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0">Subir Documento</h3>
            </div>
            <div class="card-body">
                @if ($tipoDocumento === 'ficha_registro')
                    <form action="{{ route('word.uploadFichaRegistro', ['id' => $estandar->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="ficha_registro" class="form-label">Ficha de Registro</label>
                            <input type="file" class="form-control" id="ficha_registro" name="ficha_registro"
                                accept=".pdf" required>
                            <small class="form-text text-muted">Asegúrate de que tu archivo esté en formato PDF.</small>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Subir Ficha de Registro</button>
                    </form>
                @elseif ($tipoDocumento === 'carta_firma')
                    <form action="{{ route('word.uploadCartaFirma', ['id' => $estandar->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="carta_firma" class="form-label">Carta de Firma</label>
                            <input type="file" class="form-control" id="carta_firma" name="carta_firma" accept=".pdf"
                                required>
                            <small class="form-text text-muted">Asegúrate de que tu archivo esté en formato PDF.</small>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Subir Carta de Firma</button>
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
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-radius: 10px 10px 0 0;
        }

        .btn-success {
            background-color: #24b83a;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #1f9b31;
        }

        .form-label {
            font-weight: bold;
            color: #24b83a;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        .form-text {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
@stop
