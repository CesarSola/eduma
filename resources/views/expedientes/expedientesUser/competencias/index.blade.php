@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded" style="width: 300px;">
            <h1 style="font-size: 1.5rem; margin-bottom: 0;">Mis Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="col-md-12 mb-8">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-0">
                        Competencias inscritas por {{ auth()->user()->name }}
                    </h6>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="container">
                @if ($competencias->isEmpty())
                    <div class="alert alert-primary" role="alert">
                        No tienes Competencias inscritos.
                        <a class="btn btn-primary" href="{{ route('competenciaEC.index') }}">Ir a la pestaña de inscripción
                            a una competencia</a>
                    </div>
                @else
                    <ul class="list-group">
                        @foreach ($competencias as $competencia)
                            @php
                                $usuarioId = auth()->user()->id;

                                // Verifica si hay comprobantes asociados
                                $comprobantes = $competencia->comprobantesCO;

                                // Inicializa estado
                                $estado = 'no_validado';

                                // Verifica si hay comprobantes disponibles
                                if ($comprobantes) {
                                    foreach ($comprobantes as $comprobante) {
                                        // Recupera el primer comentario de validación para el comprobante de pago
                                        $validacionComentarios = $comprobante->validaciones
                                            ->where('user_id', $usuarioId)
                                            ->first();

                                        if ($validacionComentarios) {
                                            $estado = $validacionComentarios->tipo_validacion;
                                            break; // Salir del bucle si encontramos una validación
                                        }
                                    }
                                }
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span style="font-weight: bold; color: #333;">{{ $competencia->name }}</span> -
                                    {{ $competencia->tipo }}
                                    @if ($estado == 'validar')
                                        <a href="{{ route('evidenciasEC.index', ['id' => $competencia->id, 'name' => $competencia->name]) }}"
                                            class="btn btn-primary btn-sm ml-2">Ver</a>
                                    @elseif ($estado == 'rechazar')
                                        <button type="button" class="btn btn-danger btn-sm ml-2" data-toggle="modal"
                                            data-target="#resubirModal" data-id="{{ $competencia->id }}"
                                            data-nombre="{{ $competencia->name }}">
                                            Resubir Comprobante
                                        </button>
                                    @else
                                        <span class="badge badge-warning">En validación</span>
                                    @endif
                                </div>
                                @if ($estado == 'validar')
                                    <span class="badge badge-success badge-pill">Inscrito</span>
                                @elseif ($estado == 'rechazar')
                                    <span class="badge badge-danger badge-pill">Comprobante: Rechazado</span>
                                @else
                                    <span class="badge badge-warning badge-pill">Comprobante: Subido</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    @include('expedientes.expedientesUser.competencias.resubir_comprobante')
@stop

@section('css')
    <style>
        /* Estilos personalizados aquí */
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para recargar la sección cada 5 minutos
        setInterval(function() {
            $.ajax({
                url: window.location.href, // URL actual, puede ser ajustada según necesidad
                type: 'GET', // Método de solicitud GET
                dataType: 'html', // Tipo de datos esperado (html en este caso)
                success: function(response) {
                    // Actualizar el contenido de la sección específica
                    var updatedContent = $(response).find('#1');
                    $('#1').html(updatedContent.html());
                }
            });
        }, 3000); // 300000 milisegundos = 5 minutos

        // SweetAlert para notificar sobre el estado del comprobante
        @if (session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Error',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        @endif

        // Opcional: Si quieres mostrar mensajes específicos cuando se rechaza o valida
        @if (session('estado') == 'rechazado')
            Swal.fire({
                title: 'Comprobante Rechazado',
                text: 'Por favor, revisa tu comprobante y vuelve a subirlo.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        @elseif (session('estado') == 'validado')
            Swal.fire({
                title: 'Comprobante Validado',
                text: 'Tu comprobante ha sido validado exitosamente.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('#resubirModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var competenciaId = button.data('id'); // Extrae el ID de la competencia del botón
                var competenciaName = button.data('nombre'); // Extrae el nombre de la competencia del botón

                // Actualiza los campos del modal con la información de la competencia
                var modal = $(this);
                modal.find('.modal-body #competencia_name').text('Competencia: ' + competenciaName);

                // Usa `data-id` directamente para la acción del formulario
                var formActionUrl = "{{ route('miscompetencias.guardarResubirComprobante', ':id') }}";
                formActionUrl = formActionUrl.replace(':id', competenciaId);
                modal.find('form').attr('action', formActionUrl);

                // Realiza una petición AJAX para obtener la validación de comprobantes
                $.ajax({
                    url: '{{ url('ruta/para/obtener/validacion') }}/' + competenciaId,
                    method: 'GET',
                    success: function(data) {
                        modal.find('#nombre_usuario').val(data.nombre_usuario);
                        modal.find('#tipo_validacion').val(data.tipo_validacion);
                        modal.find('#comentario_validacion').val(data.comentario);
                    }
                });
            });
        });
    </script>

@stop
