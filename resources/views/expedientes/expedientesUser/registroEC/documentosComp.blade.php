@extends('adminlte::page')

@section('title', 'Subir Comprobante de Pago')

@section('content_header')
    <h1>Subir Comprobante de Pago</h1>
@stop

@section('content')
    <form action="{{ route('competenciaEC.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="comprobante_pago">Comprobante de Pago (PDF):</label>
            <input type="file" name="comprobante_pago" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-success">Subir</button>
    </form>
@stop
