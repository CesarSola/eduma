@extends('adminlte::page')

@section('title', 'Asignar Evaluadores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Asignar Evaluadores a Usuarios</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#assignEvaluatorModal">
            Asignar Evaluador
        </button>
    </div>
@stop

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success" id="success-message" style="display:none;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Modal para asignar evaluador -->
        <div class="modal fade" id="assignEvaluatorModal" tabindex="-1" role="dialog"
            aria-labelledby="assignEvaluatorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignEvaluatorModalLabel">Asignar Evaluador</h5>
                    </div>
                    <form action="{{ route('asignar.evaluador.store') }}" method="POST" id="asignar-evaluador-form">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="usuario_id">Usuario</label>
                                <select name="usuario_id" id="usuario_id" class="form-control" required>
                                    @forelse ($usuarios as $usuario)
                                        <option value="{{ $usuario->id }}">
                                            {{ $usuario->name }} {{ $usuario->paternalSurname }} - {{ $usuario->matricula }}
                                        </option>
                                    @empty
                                        <option disabled>No hay usuarios por asignar</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="estandar_id">Estándar</label>
                                <select name="estandar_id" id="estandar_id" class="form-control" required>
                                    @forelse ($estandares as $estandar)
                                        <option value="{{ $estandar->id }}">{{ $estandar->name }}</option>
                                    @empty
                                        <option disabled>No hay estándares por asignar</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="evaluador_id">Evaluador</label>
                                <select name="evaluador_id" id="evaluador_id" class="form-control" required>
                                    @forelse ($evaluadores as $evaluador)
                                        <option value="{{ $evaluador->id }}">{{ $evaluador->name }}
                                            {{ $evaluador->paternalSurname }}</option>
                                    @empty
                                        <option disabled>No hay evaluadores disponibles</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Asignar Evaluador</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <!-- Sección para mostrar usuarios -->
                <div class="col-md-6">
                    <div class="card border-primary mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Usuarios</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($evaluaciones as $evaluacion)
                                <div class="mb-3 p-3 border rounded bg-light shadow-sm">
                                    <h6 class="font-weight-bold">Nombre del Usuario:</h6>
                                    <p class="mb-1">{{ $evaluacion->usuario->name }}
                                        {{ $evaluacion->usuario->paternalSurname }}</p>
                                    <h6 class="font-weight-bold">Matrícula:</h6>
                                    <p class="mb-1">{{ $evaluacion->usuario->matricula }}</p>
                                    <h6 class="font-weight-bold">Estándar:</h6>
                                    <p class="mb-1">{{ $evaluacion->estandar->name }}</p>
                                    <h6 class="font-weight-bold">Evaluador:</h6>
                                    <p class="mb-1">{{ $evaluacion->evaluador->name }}
                                        {{ $evaluacion->evaluador->paternalSurname }}</p>
                                </div>
                            @empty
                                <p class="text-center text-muted">No hay usuarios asignados.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sección para mostrar evaluadores -->
                <div class="col-md-6">
                    <div class="card border-success mb-4 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Evaluadores</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($evaluadores as $evaluador)
                                <div class="mb-4 p-4 border rounded bg-light shadow-sm">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="me-3">
                                            <img src="{{ $evaluador->foto }}" alt="Profile Picture" class="rounded-circle"
                                                width="60" height="60"
                                                onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">

                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-1">Nombre del Evaluador:</h6>
                                            <p class="mb-1">{{ $evaluador->name }} {{ $evaluador->paternalSurname }}</p>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold mb-2">Usuarios Asignados:</h6>
                                    <ul class="list-unstyled">
                                        @forelse ($usuariosAsignados[$evaluador->id] as $evaluacion)
                                            <li class="mb-3 p-2 border rounded bg-white shadow-sm">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span class="font-weight-bold">{{ $evaluacion->usuario->name }}
                                                            {{ $evaluacion->usuario->paternalSurname }}</span>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="badge bg-info text-white">{{ $evaluacion->estandar->name }}</span>
                                                    </div>
                                                </div>
                                            </li>
                                        @empty
                                            <p class="text-center text-muted">No hay usuarios asignados a este evaluador.
                                            </p>
                                        @endforelse
                                    </ul>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>


    @stop

    @section('css')
        <!-- Agregar cualquier CSS adicional aquí -->
    @stop

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('asignar-evaluador-form');
                const successMessage = document.getElementById('success-message');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const url = form.action;

                    console.log('Sending request to:', url);
                    console.log('Form data:', [...formData.entries()]);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                Swal.fire({
                                    title: 'Éxito',
                                    text: 'Evaluador asignado correctamente.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else if (data.error) {
                                Swal.fire({
                                    title: 'Error',
                                    text: data.error,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>
    @stop
