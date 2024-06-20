@extends('adminlte::page')

@section('title', 'Crear Documento')

@section('content_header')
    <h1>Crear Nuevo Documento</h1>
@stop

@section('content')
    <form action="{{ route('documentosnec.teststore') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
@stop

@section('css')
@stop

@section('js')
@stop
