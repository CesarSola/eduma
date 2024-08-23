<!-- Modal -->
<div class="modal fade" id="calificacionModal" tabindex="-1" aria-labelledby="calificacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-3 shadow">
            <div class="modal-header bg-success text-white rounded-top">
                <h5 class="modal-title" id="calificacionModalLabel">Asignar Calificaciones</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                @csrf
                <input type="hidden" id="modalUserId" name="user_id">
                <input type="hidden" id="modalEstandarId" name="estandar_id">
                <input type="hidden" id="modalEvaluatorId" name="evaluator_id" value="{{ Auth::id() }}">

                <div class="mb-4">
                    <label for="evaluator_name" class="form-label text-success fw-bold">Evaluador</label>
                    <input type="text" class="form-control shadow-sm border-success" id="evaluator_name" readonly>
                </div>

                <div class="mb-4">
                    <label for="user_name" class="form-label text-success fw-bold">Usuario</label>
                    <input type="text" class="form-control shadow-sm border-success" id="user_name" readonly>
                </div>

                <div class="mb-4">
                    <label for="matricula" class="form-label text-success fw-bold">Matrícula</label>
                    <input type="text" class="form-control shadow-sm border-success" id="matricula" readonly>
                </div>

                <div class="mb-4">
                    <label for="estandar_name" class="form-label text-success fw-bold">Estándar</label>
                    <textarea class="form-control shadow-sm border-success" id="estandar_name" readonly
                        style="resize: vertical; overflow: auto; min-height: 3rem;"></textarea>
                </div>

                <div class="mb-4">
                    <label for="evidencias" class="form-label text-success fw-bold">Calificación Evidencias</label>
                    <input type="text" class="form-control shadow-sm border-success" id="evidencias"
                        name="evidencias">
                </div>

                <div class="mb-4">
                    <label for="evaluacion" class="form-label text-success fw-bold">Calificación Evaluación</label>
                    <input type="text" class="form-control shadow-sm border-success" id="evaluacion"
                        name="evaluacion">
                </div>

                <div class="mb-4">
                    <label for="presentacion" class="form-label text-success fw-bold">Calificación Presentación</label>
                    <input type="text" class="form-control shadow-sm border-success" id="presentacion"
                        name="presentacion">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-5 py-2 shadow">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calificacionModal = document.getElementById('calificacionModal');

        calificacionModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Botón que abrió el modal
            var userId = button.getAttribute('data-user-id');
            var estandarId = button.getAttribute('data-estandar-id');

            // Actualizar los campos ocultos en el modal
            var modalUserId = calificacionModal.querySelector('#modalUserId');
            var modalEstandarId = calificacionModal.querySelector('#modalEstandarId');
            var modalEvaluatorId = calificacionModal.querySelector('#modalEvaluatorId');
            var evaluatorName = calificacionModal.querySelector('#evaluator_name');
            var userName = calificacionModal.querySelector('#user_name');
            var matricula = calificacionModal.querySelector('#matricula');
            var estandarName = calificacionModal.querySelector('#estandar_name');

            // Asigna los valores a los campos ocultos
            modalUserId.value = userId;
            modalEstandarId.value = estandarId;
            modalEvaluatorId.value = '{{ Auth::id() }}'; // ID del evaluador
            // Encuentra el nombre completo del evaluador
            evaluatorName.value = '{{ Auth::user()->full_name }}'; // Nombre completo del evaluador

            // Encuentra el usuario y estándar correspondientes para autorrellenar
            var usuarios = @json($usuarios);
            var estandares = @json($estandares);

            var usuario = usuarios.find(u => u.id == userId);
            var estandar = estandares.find(e => e.id == estandarId);

            if (usuario) {
                // Construye el nombre completo del usuario
                var fullName = [usuario.name, usuario.secondName, usuario.paternalSurname, usuario
                        .maternalSurname
                    ]
                    .filter(part => part) // Elimina cualquier valor null o vacío
                    .join(' '); // Une los nombres con un espacio

                userName.value = fullName;
                matricula.value = usuario.matricula;
            }

            if (estandar) {
                estandarName.value = estandar.name; // Asegúrate de que `name` es el campo correcto
            }
        });
    });
</script>
