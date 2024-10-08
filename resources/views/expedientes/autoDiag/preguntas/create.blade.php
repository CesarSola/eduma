<!-- Modal para agregar preguntas -->
<div class="modal fade" id="addPreguntaModal" tabindex="-1" aria-labelledby="addPreguntaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPreguntaModalLabel">Agregar Preguntas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPreguntaForm" action="{{ route('preguntas.store') }}" method="POST">
                    @csrf
                    <!-- Campo para el elemento (autocompletado) -->
                    <div class="mb-3">
                        <label for="elemento" class="form-label">Elemento</label>
                        <input type="text" name="elemento" id="elemento" class="form-control" readonly>
                    </div>
                    <!-- Campo para el criterio (autocompletado) -->
                    <div class="mb-3">
                        <label for="criterio" class="form-label">Criterio</label>
                        <input type="text" name="criterio" id="criterio" class="form-control" readonly>
                    </div>

                    <!-- Campos ocultos para ID de elemento y criterio -->
                    <input type="hidden" name="elemento_id" id="elemento_id">
                    <input type="hidden" name="criterio_id" id="criterio_id">
                    <input type="hidden" name="autodiagnostico_id" value="{{ $diagnostico->id }}">

                    <!-- Campo para el título de la pregunta -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la Pregunta</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>

                    <!-- Contenedor dinámico para agregar más preguntas -->
                    <div id="preguntas-container">
                        <div class="mb-3">
                            <label for="pregunta" class="form-label">Pregunta</label>
                            <textarea name="pregunta[]" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="resp_correcta" class="form-label">Respuesta Correcta</label>
                            <select name="resp_correcta[]" class="form-select" required>
                                <option value="SI">Sí</option>
                                <option value="NO">No</option>
                            </select>
                        </div>
                    </div>

                    <!-- Botón para agregar más preguntas -->
                    <button type="button" id="addPreguntaBtn" class="btn btn-secondary mb-3 btn-sm">Agregar otra
                        pregunta</button>

                    <!-- Botón para enviar el formulario completo -->
                    <button type="submit" class="btn btn-primary">Guardar Preguntas</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para autocompletar los campos de elemento y criterio en el modal
    document.querySelectorAll('button[data-bs-target="#addPreguntaModal"]').forEach(button => {
        button.addEventListener('click', function() {
            const elemento = this.getAttribute('data-elemento');
            const criterio = this.getAttribute('data-criterio');
            const elementoId = this.getAttribute('data-elemento-id'); // ID del elemento
            const criterioId = this.getAttribute('data-criterio-id'); // ID del criterio

            document.getElementById('elemento').value = elemento;
            document.getElementById('criterio').value = criterio;
            document.getElementById('elemento_id').value = elementoId; // Establecer el ID del elemento
            document.getElementById('criterio_id').value = criterioId; // Establecer el ID del criterio
        });
    });

    // Script para agregar nuevas preguntas dinámicamente
    document.getElementById('addPreguntaBtn').addEventListener('click', function() {
        const container = document.getElementById('preguntas-container');

        // Crear una nueva pregunta
        const newPregunta = document.createElement('div');
        newPregunta.classList.add('mb-3');
        newPregunta.innerHTML = `
            <label for="pregunta" class="form-label">Pregunta</label>
            <textarea name="pregunta[]" class="form-control" rows="3" required></textarea>
            <div class="mb-3">
                <label for="resp_correcta" class="form-label">Respuesta Correcta</label>
                <select name="resp_correcta[]" class="form-select" required>
                    <option value="SI">Sí</option>
                    <option value="NO">No</option>
                </select>
            </div>
            <button type="button" class="btn btn-danger btn-sm removePreguntaBtn">Eliminar</button>
        `;

        // Agregar la nueva pregunta al contenedor antes de los botones
        container.appendChild(newPregunta);

        // Agregar funcionalidad para eliminar la pregunta
        newPregunta.querySelector('.removePreguntaBtn').addEventListener('click', function() {
            container.removeChild(newPregunta);
        });
    });
</script>
