@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estandares</h1>
@stop

@section('content')
    <!-- Button trigger modal -->
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
            Nuevo
        </button>
    </div>

    <div class="mb-4 max-w-sm flex items-center">
        <label for="searchInput" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Buscar:</label>
        <input type="text" id="searchInput" class="block w-full p-2 border border-gray-300 rounded-lg"
            placeholder="Buscar...">
    </div>

    <div class="overflow-x-auto">
        <table id="competenciasTable"
            class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-200 dark:bg-gray-700">
                <tr>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Numero</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Nombre</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Tipo</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Evidencias necesarias</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($competencias as $competencia)
                    <tr class="border-b border-gray-300 dark:border-gray-700">
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $competencia->numero }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $competencia->name }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $competencia->tipo }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                            @foreach ($competencia->documentosnec as $documento)
                                <a" class="block hover:text-blue-600">{{ $documento->name }}</a>
                            @endforeach
                        </td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#editModal{{ $competencia->id }}">
                                <i class="fas fa-edit fa-sm"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf fa-sm"><a
                                        href=" href="{{ Storage::url($documento->documentos) }}" dowloA></a></i>
                            </button>
                            <a href="{{ route('competenciasAD.show', $competencia->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-user-plus fa-sm"></i>
                            </a>
                        </td>
                    </tr>
                    <div class="modal fade" id="editModal{{ $competencia->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $competencia->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $competencia->id }}">Editar competencias
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @include('lista_competencias.edit')
                                </div>
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('lista_competencias.create')

@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('competenciasTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let match = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j]) {
                            if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                                match = true;
                                break;
                            }
                        }
                    }
                    if (match) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        });
    </script>

@stop
