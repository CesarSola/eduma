@extends('adminlte::page')

@section('title', 'Crea Nuevos Estándares')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>ESTÁNDARES</h1>
        <!-- Button trigger modal -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
                Agrega un Nuevo Estándar
            </button>
        </div>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="mb-4 max-w-sm flex items-center">
            <label for="searchInput" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Buscar:</label>
            <input type="text" id="searchInput" class="block w-full p-2 border border-gray-300 rounded-lg"
                placeholder="Buscar...">
        </div>
        <div class="card">
            <div class="card-title">
                <div class="text-center">
                    <p>Crea Nuevos Estándares</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="competenciasTable">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Numero</th>
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Tipo</th>
                                <th class="text-center" scope="col">Evidencias necesarias</th>
                                <th class="text-center" scope="col">Calificación Miníma</th>
                                <th class="text-center" scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($competencias as $competencia)
                                <tr>
                                    <td class="text-center">{{ $competencia->numero }}</td>
                                    <td class="text-center">{{ $competencia->name }}</td>
                                    <td class="text-center">{{ $competencia->tipo }}</td>
                                    <td class="text-center">
                                        @foreach ($competencia->documentosnec as $documento)
                                            <span>{{ $documento->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{ $competencia->calificacion_minima }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                            data-target="#editModal{{ $competencia->id }}">
                                            <i class="fas fa-edit fa-sm"></i>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm">
                                            <i class="fas fa-file-pdf fa-sm"></i>
                                        </button>
                                        <a href="{{ route('competenciasAD.show', $competencia->id) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-user-plus fa-sm"></i>
                                        </a>
                                    </td>
                                </tr>
                                @include('lista_competencias.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('lista_competencias.create')
@stop

@section('css')

    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-content {
            width: 70%;
        }

        .right-content {
            width: 30%;
            text-align: right;
        }

        .card-title {
            background-color: #067dd2;
            text-align: center;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .list-group-item {
            text-align: center;
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .overflow-auto {
            max-height: 200px;
            /* Ajusta esta altura según sea necesario */
            overflow-y: auto;
        }

        .btn-secondary {
            margin-left: auto;
        }

        .btn-success {
            align-content: center;
            width: 50%;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')


    <!-- JS de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@stop
