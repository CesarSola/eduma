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
        <!-- Formulario de búsqueda -->
        <div class="mb-3">
            <input type="text" id="search" class="form-control" placeholder="Buscar...">
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="userTable">
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
                    @foreach ($users as $user) <!-- Aquí se reciben los usuarios filtrados -->
                    <tr data-role="{{ implode(',', $user->roles->pluck('name')->toArray()) }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
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
                            <a class="btn btn-sm btn-warning" href="{{ route('users.edit', $user->id) }}"><i class="fa fa-fw fa-edit"></i> Editar</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const userTable = document.getElementById('userTable');
        const rows = userTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        function filterTable() {
            const query = searchInput.value.toLowerCase();
            Array.from(rows).forEach(row => {
                const cells = row.getElementsByTagName('td');
                const textContent = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                if (textContent.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterTable);

        // Ordenar administradores primero
        const sortedRows = Array.from(rows).sort((a, b) => {
            const rolesA = a.dataset.role.split(',');
            const rolesB = b.dataset.role.split(',');
            if (rolesA.includes('Admin') && !rolesB.includes('Admin')) return -1;
            if (!rolesA.includes('Admin') && rolesB.includes('Admin')) return 1;
            return 0;
        });

        sortedRows.forEach(row => userTable.querySelector('tbody').appendChild(row));
    });
</script>
@stop
