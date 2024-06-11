@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

    <h1>Editar Permisos</h1>
@stop

@section('content')
<form method="POST" action="{{ route('permissions.update',$permission->id) }}">
    @csrf
    @method('PUT')
    <div class="input-group input-group-outline mt-3">
        <label class="form-label" for="name"></label>
        <input type="text" name="name" id="name" value="{{ $permission->name }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="">
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    
    <div class="input-group input-group-outline mt-3">
        <label class="form-label" for="description"></label>
        <input type="text" name="description" id="description" value="{{ $permission->description }}" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">
        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
    <br>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    <br>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-info">{{ __('Cerrar') }}</button>
    </div>
</form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop