@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

<h1>Usuarios</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id}}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @foreach ($user->roles as $role)
                            <span class="badge badge-primary">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if($user->active)
                            <span class="badge badge-success">Activo</span>
                            @else
                            <span class="badge badge-danger">Desactivado</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
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
