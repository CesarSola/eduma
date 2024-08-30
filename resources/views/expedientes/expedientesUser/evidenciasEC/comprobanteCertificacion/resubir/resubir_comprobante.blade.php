<!-- Modal -->
<div class="modal fade" id="resubirModal" tabindex="-1" role="dialog" aria-labelledby="resubirModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resubirModalLabel">Re-subir Comprobante de Pago</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <h5 class="card-title" id="competencia_name">Competencia: </h5>
                    <p class="card-text">Por favor, sube nuevamente el comprobante de certificación.</p>
                </div>

                <div class="mb-4">
                    <h6 class="font-weight-bold">Detalles de Rechazo</h6>
                    <div class="form-group">
                        <label for="nombre_usuario">Nombre del Usuario:</label>
                        <input type="text" class="form-control" id="nombre_usuario" readonly>
                    </div>
                    <div class="form-group">
                        <label for="tipo_validacion">Tipo de Validación Anterior:</label>
                        <input type="text" class="form-control" id="tipo_validacion" readonly>
                    </div>
                    <div class="form-group">
                        <label for="comentario_validacion">Motivo de Rechazo:</label>
                        <textarea class="form-control" id="comentario_validacion" rows="4" readonly></textarea>
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- No necesitas especificar `action` aquí, ya que se configura en el JavaScript -->
                    <div class="form-group">
                        <label for="nuevo_comprobante_pago">Nuevo Comprobante de Pago:</label>
                        <input type="file" class="form-control-file" id="nuevo_comprobante_pago"
                            name="nuevo_comprobante_pago" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success mr-2">Guardar y Re-subir</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar SweetAlert2 cuando se sube un comprobante exitosamente
    @if (session('success'))
        Swal.fire({
            title: 'Éxito',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
</script>
