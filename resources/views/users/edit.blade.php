@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

    <h1>Editar Usuarios</h1>
@stop

@section('content')
   
<div class="card card-plain">
    <div class="card-header">
        <h4 class="font-weight-bolder"> Editar Registro de Usuarios</h4>
        <p class="mb-0">Edite el Registro</p>
    </div>
    <div class="card-body">
      <form action="{{ route('users.update', $user->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
              <label for="name" class="form-label">Nombre:</label>
              <input type="text" class="form-control" id="name" name="name"
                  value="{{ $user->name }}">
          </div>

          <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico:</label>
              <input type="email" class="form-control" id="email" name="email"
                  value="{{ $user->email }}">
          </div>
          
          <div class="mb-3">
              <label class="form-label">Roles:</label>
              <div>
                  @foreach ($roles as $role)
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox"
                              id="role_{{ $role->id }}" name="roles[]"
                              value="{{ $role->id }}"
                              {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                          <label class="form-check-label"
                              for="role_{{ $role->id }}">{{ $role->name }}</label>
                      </div>
                  @endforeach
              </div>
          </div>
          
                  <div class="box-footer mt20">
                      <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                  </div>
                  <br>
                  <div class="box-footer mt20">
                      <button type="submit" class="btn btn-info">{{ __('Cerrar') }}</button>
                  </div>
          </div>
      </form>
    </div>
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
