@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

    <h1>Crear Permisos</h1>
@stop

@section('content')


<div class="card-body">
    <form method="POST" action="{{ route('permissions.store') }}">
        @csrf
        <div class="form-group mt-3">
            <label class="form-label" for="name">Nombre del Permiso</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="">
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        
        

        <div class="form-group mt-3">
            <label class="form-label" for="description">Descripción del Permiso</label>
            <input type="text" name="description" id="description" value="{{old('description')}}" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"></textarea>
            {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Estilo personalizado para colocar la etiqueta encima del input */
        .form-group label {
            display: block;
            margin-bottom: 5px; /* Espacio entre la etiqueta y el input */
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop