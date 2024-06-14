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
        .permission-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px; /* Espacio entre elementos */
        }

        .form-check {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-check-input {
            margin-right: 10px;
        }

        .form-check-label {
            display: flex;
            align-items: center;
        }
    </style>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
