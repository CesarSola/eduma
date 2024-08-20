<!-- Modal para asignar fechas -->
@foreach ($usuarios as $usuario)
    @foreach ($usuario->estandares as $estandar)
        <div class="modal fade" id="modalAgregarFechas{{ $usuario->id }}-{{ $estandar->id }}" tabindex="-1" role="dialog"
            aria-labelledby="modalAgregarFechasLabel{{ $usuario->id }}-{{ $estandar->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <!-- Encabezado del modal -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalAgregarFechasLabel{{ $usuario->id }}-{{ $estandar->id }}">
                            Agregar Fechas para {{ $estandar->name }}
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
                                    <p><strong>Usuario:</strong> {{ $usuario->name }} {{ $usuario->secondName }}
                                        {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Matrícula:</strong> {{ $usuario->matricula }} </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Estándar:</strong> {{ $estandar->numero }} {{ $estandar->name }}</p>
                                </div>
                            </div>
                            <!-- Formulario para agregar fechas y horarios -->
                            <form id="formAgregarFechas{{ $usuario->id }}-{{ $estandar->id }}">
                                <div class="form-group">
                                    <label for="fecha1-{{ $usuario->id }}-{{ $estandar->id }}">Fecha 1:</label>
                                    <input type="date" id="fecha1-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control" required>
                                    <input type="time" id="hora1-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control mt-2" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha2-{{ $usuario->id }}-{{ $estandar->id }}">Fecha 2:</label>
                                    <input type="date" id="fecha2-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control" required>
                                    <input type="time" id="hora2-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control mt-2" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha3-{{ $usuario->id }}-{{ $estandar->id }}">Fecha 3:</label>
                                    <input type="date" id="fecha3-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control" required>
                                    <input type="time" id="hora3-{{ $usuario->id }}-{{ $estandar->id }}"
                                        class="form-control mt-2" required>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Pie del modal -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary"
                            id="guardarFechasBtn{{ $usuario->id }}-{{ $estandar->id }}">Guardar Fechas</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script para manejar la adición de fechas -->
        <script>
            document.getElementById('guardarFechasBtn{{ $usuario->id }}-{{ $estandar->id }}').addEventListener('click',
                function() {
                    var fechas = [{
                            fecha: $('#fecha1-{{ $usuario->id }}-{{ $estandar->id }}').val(),
                            hora: [$('#hora1-{{ $usuario->id }}-{{ $estandar->id }}').val()]
                        },
                        {
                            fecha: $('#fecha2-{{ $usuario->id }}-{{ $estandar->id }}').val(),
                            hora: [$('#hora2-{{ $usuario->id }}-{{ $estandar->id }}').val()]
                        },
                        {
                            fecha: $('#fecha3-{{ $usuario->id }}-{{ $estandar->id }}').val(),
                            hora: [$('#hora3-{{ $usuario->id }}-{{ $estandar->id }}').val()]
                        }
                    ];

                    $.ajax({
                        url: '{{ route('competencias.guardar-fechas-modal', ['competencia' => 'COMPETENCIA_ID_PLACEHOLDER']) }}'
                            .replace('COMPETENCIA_ID_PLACEHOLDER', '{{ $estandar->id }}'),
                        method: 'POST',
                        data: {
                            usuario_id: '{{ $usuario->id }}',
                            estandar_id: '{{ $estandar->id }}',
                            fechas: fechas,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Fechas Guardadas',
                                    text: 'Las fechas se han guardado correctamente.',
                                    confirmButtonText: 'Aceptar'
                                }).then(function() {
                                    $('#modalAgregarFechas{{ $usuario->id }}-{{ $estandar->id }}')
                                        .modal('hide');
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error al guardar las fechas. Por favor, inténtalo de nuevo.',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    });
                });
        </script>
    @endforeach
@endforeach
