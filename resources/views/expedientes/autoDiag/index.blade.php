@extends('adminlte::page')

@section('title', 'Autodiagnósticos')

@section('content_header')
    <h1 class="text-center">Lista de Autodiagnósticos</h1>
@stop

@section('content')
    <h1>Diagnósticos Automatizados</h1>

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createAutoDiagModal">
        Crear Autodiagnóstico
    </button>

    <table class="table">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>No. Elementos</th>
                <th>Nombres</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($autodiagnosticos as $diagnostico)
                <tr>
                    <td>{{ $diagnostico->titulo }}</td>
                    <td>{{ $diagnostico->descripcion }}</td>
                    <td>{{ $diagnostico->elementos }}</td> <!-- Aquí solo muestras el número -->
                    <td>
                        <ul>
                            @foreach ($elementos as $elemento)
                                @if ($elemento->autodiagnostico_id == $diagnostico->id)
                                    <li>{{ $elemento->nombre }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('autodiagnosticos.show', $diagnostico->id) }}" class="btn btn-primary">Ver</a>
                        <button class="btn btn-danger" onclick="deleteAutoDiag({{ $diagnostico->id }})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('expedientes.autoDiag.create')
@stop



@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Estilo personalizado */
        body {
            background-color: #f8f9fa;
            /* Color de fondo claro */
        }

        .card {
            border: 1px solid #007bff;
            /* Borde azul */
        }

        .table-success {
            background-color: #e2f0d9;
            /* Fondo verde claro para el encabezado de la tabla */
        }

        .btn-success {
            background-color: #28a745;
            /* Color verde para el botón "Ver" */
            border-color: #28a745;
            /* Borde verde para el botón "Ver" */
        }

        .btn-success:hover {
            background-color: #218838;
            /* Color verde más oscuro al pasar el mouse */
            border-color: #1e7e34;
            /* Borde más oscuro al pasar el mouse */
        }
    </style>
@stop

@section('js')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        console.log('Vista de Usuarios cargada correctamente.');

        function deleteAutoDiag(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás deshacer esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma la eliminación, se envía la solicitud
                    $.ajax({
                        url: '/autodiagnosticos/' + id,
                        type: 'POST', // Usar POST para hacer la eliminación
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}' // Incluir el token CSRF
                        },
                        success: function(response) {
                            // Mostrar mensaje de éxito
                            Swal.fire(
                                '¡Eliminado!',
                                'El autodiagnóstico ha sido eliminado.',
                                'success'
                            ).then(() => {
                                location.reload(); // Recargar la página
                            });
                        },
                        error: function(response) {
                            // Mostrar mensaje de error
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar el autodiagnóstico.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire(
                '¡Éxito!',
                '{{ session('success') }}',
                'success'
            );
        </script>
    @endif

@stop
