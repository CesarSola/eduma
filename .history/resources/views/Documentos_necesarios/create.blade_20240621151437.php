pon este en el créate
<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Crear nuevo documento necesario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('documentosnec.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción:</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>

                    <div class="form-group">
                        <label for="documento">Documento:</label>
                        <input type="file" class="form-control" id="documento" name="documento"
                            accept="application/pdf" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Subir documento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function previewPDF(event, previewId) {
        var output = document.getElementById(previewId);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.classList.remove('hidden');
        output.style.display = 'block';
    }
</script>
