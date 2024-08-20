<!-- Modal -->
<div class="modal fade" id="resubirModal" tabindex="-1" role="dialog" aria-labelledby="resubirModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resubirModalLabel">Resubir Documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- Información del usuario y documento -->
                    <div class="mb-3">
                        <h6 class="text-secondary font-weight-bold">
                            <span id="usuario-name"></span>, sube de nuevo el documento marcado aquí para su revisión
                        </h6>

                        <div class="alert alert-info">
                            <p><strong>Nombre del documento rechazado: </strong>
                                <span id="documento-name"></span><strong> para el Estándar: </strong>
                                <span id="estandar-name"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Formulario de subida de documento -->
                    <form id="resubirForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Seleccionar archivo</label>
                            <input type="file" id="file" name="file" class="form-control-file" accept=".pdf"
                                required>
                            <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF para
                                poder subirlo.</small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Subir Documento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluye jQuery y Bootstrap JS para manejar el modal -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Script para actualizar los datos del modal
    $('#resubirModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var estandar = button.data('estandar');
        var usuario = button.data('usuario');

        var modal = $(this);
        modal.find('#usuario-name').text(usuario);
        modal.find('#documento-name').text(nombre);
        modal.find('#estandar-name').text(estandar);
        modal.find('#resubirForm').attr('action', '{{ route('evidencias.resubir.submit', ':id') }}'.replace(
            ':id', id));
    });
</script>
