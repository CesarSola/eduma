@extends('adminlte::page')

@section('title', 'Subir Documentos de Inscripción')

@section('content_header')
    <h1>Subir Documentos de Inscripción</h1>
@stop

@section('content')
    <form action="{{ route('documentosIns.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="ficha_inscripcion">Ficha de Inscripción (Word):</label>
            <input type="file" name="ficha_inscripcion" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Subir</button>
    </form>
@stop
