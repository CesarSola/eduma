@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<h1>Roles</h1>
@stop

@section('content')


<div class="row">
    @can('roles.create')
    <div class="float-right">
        <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm float-right"  data-placement="left">
          {{ __('Agregar') }}
        </a>
      </div>
    @endcan
</div>


<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->id}}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('roles.edit')
                            <a class="btn btn-sm btn-warning" href="{{ route('roles.edit',$role->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                            @endcan
                        </td>
                        <td>
                            @can('roles.destroy')
                            <form action="{{ route('roles.destroy',$role->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return showConfirmation()"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                            </form>
                            <script>
                                function showConfirmation() {
                                    return confirm('¿Estás seguro de que deseas eliminar este registro?');
                                }
                            </script>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop
