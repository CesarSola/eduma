<!-- Modal para editar preguntas -->
<div class="modal fade" id="editPreguntaModal" tabindex="-1" aria-labelledby="editPreguntaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPreguntaModalLabel">Editar Pregunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPreguntaForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="autodiagnostico_id" id="edit-autodiagnostico_id">

                    <!-- Campo para el título de la pregunta -->
                    <div class="mb-3">
                        <label for="edit-titulo" class="form-label">Título de la Pregunta</label>
                        <input type="text" name="titulo" id="edit-titulo" class="form-control" required>
                    </div>

                    <!-- Campo para la pregunta -->
                    <div class="mb-3">
                        <label for="edit-pregunta" class="form-label">Pregunta</label>
                        <textarea name="pregunta" id="edit-pregunta" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Campo para respuesta correcta -->
                    <div class="mb-3">
                        <label for="edit-resp_correcta" class="form-label">Respuesta Correcta</label>
                        <select name="resp_correcta" id="edit-resp_correcta" class="form-select" required>
                            <option value="SI">Sí</option>
                            <option value="NO">No</option>
                        </select>
                    </div>

                    <!-- Campos ocultos para ids -->
                    <input type="hidden" name="elemento_id" id="edit-elemento_id">
                    <input type="hidden" name="criterio_id" id="edit-criterio_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="editPreguntaBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para cargar los datos en el modal de edición
    document.querySelectorAll('.btn-warning[data-bs-target="#editPreguntaModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute(
            'data-id'); // Asumiendo que tienes un atributo data-id con el ID de la pregunta
            const elementoId = this.getAttribute('data-elemento-id');
            const criterioId = this.getAttribute('data-criterio-id');
            const autodiagnosticoId = this.getAttribute('data-autodiagnostico-id');

            // Hacer una solicitud para obtener los datos de la pregunta
            fetch(`/preguntas/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit-titulo').value = data.titulo;
                    document.getElementById('edit-pregunta').value = data.pregunta;
                    document.getElementById('edit-resp_correcta').value = data.resp_correcta;
                    document.getElementById('edit-elemento_id').value = elementoId;
                    document.getElementById('edit-criterio_id').value = criterioId;
                    document.getElementById('edit-autodiagnostico_id').value = autodiagnosticoId;

                    // Actualizar la acción del formulario
                    document.getElementById('editPreguntaForm').action = `/preguntas/${id}`;
                });
        });
    });

    // Guardar cambios en la pregunta
    document.getElementById('editPreguntaBtn').addEventListener('click', function() {
        document.getElementById('editPreguntaForm').submit();
    });
</script>
