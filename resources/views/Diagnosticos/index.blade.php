@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Diagnostico</h1>
@stop

@section('content')
    <!-- Button trigger modal -->
    <div class="mb-4 d-flex justify-content-between">
        <button data-modal-target="create-modal" data-toggle="modal" data-target="#createe"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Crear nuevo diagnóstico
        </button>
        <a href="{{ route('usuarios.asignar-diagnosticos') }}"  class="btn btn-success">
            Asignar Nuevos Diagnósticos
        </a>
    </div>


    <table id="documentos-table" class="table table-bordered table-hover">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagnosticos as $diagnostico)
                    <tr>
                        <td>{{ $diagnostico->id }}</td>
                        <td>{{ $diagnostico->codigo }}</td>
                        <td>{{ $diagnostico->nombre }}</td>
                        <td>{{ $diagnostico->descripcion }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editModal{{ $diagnostico->id }}">
                            <i class="fas fa-edit fa-sm"></i> Editar
                        </button>
                        <button class="btn btn-info btn-sm">
                            <a href="{{ route('formulario') }}" style="color: white; text-decoration: none;">
                                <i class="fas fa-eye fa-sm"></i> Ver
                            </a>
                        </button>

                            <form action="{{ route('diagnosticos.destroy', $diagnostico->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                <!-- Modal para editar documento -->
                <div class="modal fade" id="editModal{{ $diagnostico->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $diagnostico->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $diagnostico->id }}">Editar diagnostico necesario
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('Diagnosticos.edit')
                            </div>
                            <div class="modal-footer">
                                <!-- Puedes agregar botones adicionales aquí si es necesario -->
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
    @include('Diagnosticos.create')

@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#documentos-table').DataTable();
        });
    </script>
@stop
