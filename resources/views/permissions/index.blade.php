@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

<h1>Tabla de Permisos</h1>
@stop

@section('content')

<div class="row">
    @can('permissions.create')
    <div class="col-md-6 offset-md-6 text-right">
        <a href="{{ route('permissions.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Agregar Permiso</a>
    </div>
    @endcan
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->description }}</td>
                        <td>
                            <div class="btn-group">
                                @can('permissions.edit')
                                <a class="btn btn-warning" href="{{ route('permissions.edit',$permission->id) }}"><i class="fas fa-edit"></i> Editar</a>
                                @endcan
                                @can('permissions.destroy')
                                <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')"><i class="fas fa-trash"></i> Eliminar</button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
 
<div class="card-footer d-flex justify-content-end">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            {{-- Anterior --}}
            @if($permissions->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $permissions->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            {{-- Páginas --}}
            @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                <li class="page-item {{ $permissions->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $permissions->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Siguiente --}}
            @if($permissions->currentPage() < $permissions->lastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $permissions->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop


