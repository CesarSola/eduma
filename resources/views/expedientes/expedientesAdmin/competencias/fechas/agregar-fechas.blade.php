<!-- Modal -->
<div class="modal fade" id="modalAgregarFechas" tabindex="-1" role="dialog" aria-labelledby="modalAgregarFechasLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarFechasLabel">Agregar Fechas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar fechas -->
                <form action="{{ route('competencias.guardar-fechas-modal', ['competencia' => $competencia->id]) }}"
                    method="POST" id="formGuardarFechas">
                    @csrf
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ $selectedUserId }}">

                    <!-- Selección de Usuario -->
                    <div class="form-group mb-4">
                        <label for="usuario">Seleccionar Usuario:</label>
                        <select id="usuario" name="usuario_id" class="form-control" required>
                            <option value="">Seleccione un usuario</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ $usuario->id == $selectedUserId ? 'selected' : '' }}>
                                    {{ $usuario->name }} {{ $usuario->secondName }} {{ $usuario->paternalSurname }}
                                    {{ $usuario->maternalSurname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Selección de Estándares -->
                    <div class="form-group mb-4">
                        <label for="estandar_id">Seleccionar Estándar:</label>
                        <select id="estandar" name="estandar_id" class="form-control" required>
                            <option value="">Seleccione un estándar</option>
                            <!-- Opciones se llenarán dinámicamente -->
                        </select>
                    </div>

                    <!-- Fechas y Horarios -->
                    <div id="fechasContainer">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="form-group mb-4">
                                <label for="fecha">Fecha:</label>
                                <input type="date" name="fechas[]" class="form-control" required>

                                <label for="hora" class="mt-2">Horario:</label>
                                <input type="time" name="horarios[{{ $i }}][]" class="form-control"
                                    required>
                            </div>
                        @endfor
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Guardar Fechas y Horarios</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const usuarioSelect = document.getElementById('usuario');
        const estandarSelect = document.getElementById('estandar');

        // Función para actualizar los estándares cuando se cambia el usuario
        usuarioSelect.addEventListener('change', function() {
            const userId = this.value;
            estandarSelect.innerHTML =
                '<option value="">Seleccione un estándar</option>'; // Limpiar opciones

            if (userId) {
                // Buscar estándares del usuario seleccionado
                const usuarios =
                    @json($usuarios); // Convertir la colección de usuarios a JSON
                const selectedUser = usuarios.find(user => user.id == userId);

                if (selectedUser) {
                    selectedUser.estandares.forEach(estandar => {
                        const option = document.createElement('option');
                        option.value = estandar.id;
                        option.textContent = estandar.name;
                        estandarSelect.appendChild(option);
                    });
                }
            }
        });

        // Disparar evento de cambio para llenar el select de estándares si hay un usuario seleccionado
        if ({{ $selectedUserId ? 'true' : 'false' }}) {
            usuarioSelect.dispatchEvent(new Event('change'));
        }
    });
</script>
