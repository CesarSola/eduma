@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<script src="https:/kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
<h1>Roles</h1>
@stop

@section('content')

<div class="row mb-3">
    @can('roles.create')
    <div class="col-md-6 offset-md-6 text-right">
        <a href="{{ route('roles.create') }}" class="btn btn-success"><i class="fas fa-plus"></i>
            {{ __('Agregar') }}
        </a>
    </div>
    @endcan
</div>
<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Buscar roles...">
</div>

<div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="rolesTable">
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
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('roles.edit')
                            <a class="btn btn-sm btn-warning" href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                            @endcan
                        </td>
                        <td>
                            @can('roles.destroy')
                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
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
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#rolesTable tbody tr');

        rows.forEach(row => {
            let roleName = row.cells[1].textContent.toLowerCase();

            if (roleName.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@stop
