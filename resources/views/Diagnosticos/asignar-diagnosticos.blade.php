@extends('adminlte::page')

@section('title', 'Asignar Diagnósticos')

@section('content_header')
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1 style="flex: 1;">Asignar Diagnósticos a Usuarios</h1>
    <div style="display: flex; gap: 10px;">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Asignar diagnostico
            </button>
        <a href="{{ route('usuarios.con-diagnosticos') }}" class="btn btn-warning">
            Diagnósticos Asignados
        </a>
        <a href="{{ route('diagnosticos.index') }}" class="btn btn-success">
            <i class="fas fa-arrow-left"></i>
        </a>

        <!-- Button trigger modal -->


    </div>
</div>

@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('usuarios.guardar-asignacion') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="user_id">Selecciona un Usuario:</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="" disabled selected>Selecciona un usuario</option>
                       @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="diagnostico_id">Selecciona un Diagnóstico:</label>
                    <select name="diagnostico_id" id="diagnostico_id" class="form-control">
                        <option value="" disabled selected>Selecciona un diagnóstico</option>
                        @foreach($diagnosticos as $diagnostico)
                            <option value="{{ $diagnostico->id }}" data-codigo="{{ $diagnostico->codigo }}">{{ $diagnostico->codigo }}</option>
                        @endforeach
                    </select>
                </div>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="asignar-diagnostico" disabled>Asignar Diagnóstico</button>
        </div>
    </form>
      </div>
    </div>
  </div>

    <h2 class="mt-5">Usuarios y Estándares inscritos</h2>
    <table id="usuarios-table" class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Estándares inscritos</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>
                        @if(isset($estandares[$usuario->id]) && $estandares[$usuario->id]->isNotEmpty())
                            <ul>
                                @foreach($estandares[$usuario->id] as $estandar)
                                    <li>
                                        Numero: {{ $estandar->numero }} <br>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            No está inscrito en ningún estándar.
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#usuarios-table').DataTable({
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });

        // Manejar el cambio en el usuario y el diagnóstico
        $('#user_id, #diagnostico_id').on('change', function() {
            const userId = $('#user_id').val();
            const diagnosticoId = $('#diagnostico_id').val();

            // Verifica si hay un usuario y un diagnóstico seleccionados
            if (userId && diagnosticoId) {
                // Busca si el usuario tiene el estándar correspondiente
                const estandares = @json($estandares);
                const estandarNumeros = estandares[userId]?.map(e => e.numero) || [];

                // Obtener el código del diagnóstico seleccionado
                const diagnosticoCodigo = $('#diagnostico_id option:selected').data('codigo');

                // Habilita el botón si el diagnóstico coincide con los estándares
                if (estandarNumeros.includes(diagnosticoCodigo)) {
                    $('#asignar-diagnostico').prop('disabled', false);
                } else {
                    $('#asignar-diagnostico').prop('disabled', true);
                }
            } else {
                $('#asignar-diagnostico').prop('disabled', true);
            }
        });
    });
</script>
@stop
