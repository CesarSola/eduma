@extends('adminlte::page')

@section('title', 'Evaluadores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Evaluadores</h1>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Evaluadores</h1>
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createEvaluadorModal">
                    Crear Nuevo Evaluador
                </button>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($evaluadores as $evaluador)
                            <tr>
                                <td>{{ $evaluador->id }}</td>
                                <td>{{ $evaluador->name }}</td>
                                <td>{{ $evaluador->secondName }}</td>
                                <td>{{ $evaluador->paternalSurname }}</td>
                                <td>{{ $evaluador->maternalSurname }}</td>
                                <td>{{ $evaluador->email }}</td>
                                <td>
                                    <a href="{{ route('evaluadores.show', $evaluador->id) }}"
                                        class="btn btn-info btn-sm">Ver</a>
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#editEvaluadorModal{{ $evaluador->id }}">
                                        <i class="fas fa-edit fa-sm"></i>
                                    </button>
                                    <form action="{{ route('evaluadores.destroy', $evaluador->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for editing evaluator -->
    @foreach ($evaluadores as $evaluador)
        <div class="modal fade" id="editEvaluadorModal{{ $evaluador->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editEvaluadorModalLabel{{ $evaluador->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEvaluadorModalLabel{{ $evaluador->id }}">Editar Evaluador</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editEvaluadorForm{{ $evaluador->id }}"
                            action="{{ route('evaluadores.update', $evaluador->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="edit_name{{ $evaluador->id }}">Nombre</label>
                                <input type="text" class="form-control" id="edit_name{{ $evaluador->id }}"
                                    name="name" value="{{ old('name', $evaluador->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_secondName{{ $evaluador->id }}">Segundo Nombre</label>
                                <input type="text" class="form-control" id="edit_secondName{{ $evaluador->id }}"
                                    name="secondName" value="{{ old('secondName', $evaluador->secondName) }}">
                            </div>
                            <div class="form-group">
                                <label for="edit_paternalSurname{{ $evaluador->id }}">Apellido Paterno</label>
                                <input type="text" class="form-control" id="edit_paternalSurname{{ $evaluador->id }}"
                                    name="paternalSurname"
                                    value="{{ old('paternalSurname', $evaluador->paternalSurname) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_maternalSurname{{ $evaluador->id }}">Apellido Materno</label>
                                <input type="text" class="form-control" id="edit_maternalSurname{{ $evaluador->id }}"
                                    name="maternalSurname"
                                    value="{{ old('maternalSurname', $evaluador->maternalSurname) }}">
                            </div>
                            <div class="form-group">
                                <label for="edit_email{{ $evaluador->id }}">Email</label>
                                <input type="email" class="form-control" id="edit_email{{ $evaluador->id }}"
                                    name="email" value="{{ old('email', $evaluador->email) }}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @include('expedientes.expedientesAdmin.competencias.evaluadores.create')
@stop

@section('css')
    <!-- Agregar cualquier CSS adicional aquí -->
@stop

@section('js')
    <!-- Bootstrap JS Bundle -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@stop
