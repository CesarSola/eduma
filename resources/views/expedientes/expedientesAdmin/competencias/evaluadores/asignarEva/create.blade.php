<!-- Modal para asignar evaluador -->
@foreach ($users as $usuario)
    @foreach ($usuario->comprobantesCO as $comprobante)
        @if ($comprobante->estandar)
            <div class="modal fade" id="asignarEvaluadorModal{{ $usuario->id }}-{{ $comprobante->estandar->id }}"
                tabindex="-1" role="dialog"
                aria-labelledby="asignarEvaluadorModalLabel{{ $usuario->id }}-{{ $comprobante->estandar->id }}"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <!-- Encabezado del modal -->
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"
                                id="asignarEvaluadorModalLabel{{ $usuario->id }}-{{ $comprobante->estandar->id }}">
                                Asignar Evaluador para {{ $comprobante->estandar->name }}
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Cuerpo del modal -->
                        <div class="modal-body">
                            <div class="container-fluid">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p><strong>Usuario:</strong> {{ $usuario->name }}
                                            {{ $usuario->secondName }} {{ $usuario->paternalSurname }}
                                            {{ $usuario->maternalSurname }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Matrícula:</strong> {{ $usuario->matricula }} </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Estándar:</strong>{{ $comprobante->estandar->numero }}
                                            {{ $comprobante->estandar->name }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="evaluador-{{ $usuario->id }}-{{ $comprobante->estandar->id }}"
                                        class="font-weight-bold">Seleccionar
                                        Evaluador:</label>
                                    <select id="evaluador-{{ $usuario->id }}-{{ $comprobante->estandar->id }}"
                                        class="form-control custom-select">
                                        @foreach ($evaluadores as $evaluador)
                                            <option value="{{ $evaluador->id }}">{{ $evaluador->name }}
                                                {{ $evaluador->secondName }}
                                                {{ $evaluador->paternalSurname }}
                                                {{ $evaluador->maternalSurname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Pie del modal -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary"
                                id="asignarBtn{{ $usuario->id }}-{{ $comprobante->estandar->id }}">Asignar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Script para manejar la asignación del evaluador -->
            <script>
                document.getElementById('asignarBtn{{ $usuario->id }}-{{ $comprobante->estandar->id }}').addEventListener(
                    'click',
                    function() {
                        console.log(
                            "Asignar botón clicado para usuario {{ $usuario->id }} y estandar {{ $comprobante->estandar->id }}"
                            );
                        var evaluadorId = document.getElementById(
                            'evaluador-{{ $usuario->id }}-{{ $comprobante->estandar->id }}').value;

                        // Enviar la solicitud Ajax
                        $.ajax({
                            url: '{{ route('asignar.evaluador.store') }}',
                            method: 'POST',
                            data: {
                                usuario_id: '{{ $usuario->id }}',
                                estandar_id: '{{ $comprobante->estandar->id }}',
                                evaluador_id: evaluadorId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Asignación exitosa',
                                        text: 'El evaluador ha sido asignado correctamente.',
                                        confirmButtonText: 'Aceptar'
                                    }).then(function() {
                                        $('#asignarEvaluadorModal{{ $usuario->id }}-{{ $comprobante->estandar->id }}')
                                            .modal('hide');
                                        location.reload();
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Ocurrió un error al asignar el evaluador. Por favor, inténtalo de nuevo.',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    });
            </script>
        @endif
    @endforeach
@endforeach
