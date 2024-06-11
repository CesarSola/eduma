@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Crear Roles</h1>
@stop

@section('content')
    
<div class="card-body">
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Rol</label>
            <div class="input-group input-group-outline mt-3">
                <input type="text" name="name" id="name"
                    class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    value="{{ old('name') }}" placeholder="Nombre del Rol">
                @if ($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>
        </div>

        <h2>Listado de Permisos</h2>
<div class="mt-4 permission-container">
    @foreach ($permissions as $permission)
        <div class="form-check">
            <input type="checkbox" name="permissions[]" id="permiso_{{ $permission->id }}" value="{{ $permission->id }}">
            <label for="permiso_{{ $permission->id }}">
                {{ $permission->description }}
            </label>
        </div>
    @endforeach
</div>
        
        
        <br>
        <div class="box-footer mt20">
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </div>
    </form> 
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
        .permission-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-gap: 10px; /* Espacio entre elementos */
         }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
