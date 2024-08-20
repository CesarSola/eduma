<!-- Modal -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="modal fade" id="uploadEvidenceModal" tabindex="-1" aria-labelledby="uploadEvidenceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadEvidenceModalLabel">Subir Evidencia</h5>
            </div>
            <div class="modal-body">
                <form id="uploadEvidenceForm" action="{{ route('evidenciasEC.upload', $documento->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="estandar_id" value="">
                    <div class="form-group">
                        <div class="alert alert-info" id="documentNameAlert">
                            <p><strong>Nombre del documento:</strong> </p>
                        </div>
                        <label for="documento">Seleccionar Documento</label>
                        <input type="file" class="form-control-file @error('documento') is-invalid @enderror"
                            id="documento" name="documento" accept=".pdf">
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF para poder
                            subirlo.</small>
                        @error('documento')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .modal-content {
        border-radius: 0.5rem;
        /* Bordes redondeados para el modal */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        /* Sombra del modal */
    }

    .modal-header {
        border-bottom: 1px solid #e0e0e0;
        /* Borde inferior en el encabezado del modal */
        background-color: #13a200;
        /* Fondo azul para el encabezado */
        color: #ffffff;
        /* Texto blanco en el encabezado */
    }

    .modal-title {
        font-weight: bold;
        /* Negrita para el título del modal */
    }

    .modal-body {
        padding: 1.5rem;
        /* Relleno adicional en el cuerpo del modal */
    }

    .modal-footer {
        border-top: 1px solid #e0e0e0;
        /* Borde superior en el pie del modal */
        padding: 0.75rem;
        /* Relleno adicional en el pie del modal */
    }

    .btn-primary {
        background-color: #13a200;
        border-color: #13a200;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #3c9100;
        border-color: #008510;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .form-control-file {
        border: 1px solid #ced4da;
        border-radius: .375rem;
    }

    .form-text {
        font-size: 0.875rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('uploadEvidenceModal');
        const modal = new bootstrap.Modal(modalElement);

        modalElement.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const documentoId = button.getAttribute('data-documento-id');
            const estandarId = button.getAttribute('data-estandar-id');
            const documentoName = button.getAttribute('data-documento-name');

            // Actualizar la acción del formulario
            const form = document.getElementById('uploadEvidenceForm');
            form.action = form.action.replace(/evidencias\/\d+\/upload/,
                `evidencias/${documentoId}/upload`);

            // Establecer el valor del campo oculto para el estandar_id
            form.querySelector('input[name="estandar_id"]').value = estandarId;

            // Actualizar el nombre del documento en el modal
            const documentNameAlert = document.getElementById('documentNameAlert');
            documentNameAlert.querySelector('strong').textContent = documentoName;
        });

        // Manejo del envío del formulario
        document.getElementById('uploadEvidenceForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const url = this.action;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: data.message,
                            confirmButtonText: 'Cerrar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Cerrar el modal
                                modal.hide();
                                // Recargar la página después de cerrar el modal
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message,
                            confirmButtonText: 'Cerrar'
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
