<!-- Modal para crear autodiagnóstico -->
<div class="modal fade" id="createAutoDiagModal" tabindex="-1" aria-labelledby="createAutoDiagModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createAutoDiagModalLabel">Crear Autodiagnóstico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createAutoDiagForm" action="{{ route('autodiagnosticos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="estandar_id" class="form-label">Estandar</label>
                        <select name="estandar_id" class="form-select" required>
                            <option value="">Seleccione un estándar</option>
                            @foreach ($estandares as $estandar)
                                <option value="{{ $estandar->id }}">{{ $estandar->numero }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="elementos" class="form-label">Número de Elementos (3-5)</label>
                        <input type="number" id="elementos" name="elementos" class="form-control" min="3"
                            max="5" required>
                    </div>

                    <div id="elementoFields">
                        <!-- Los campos de elementos y criterios se generarán dinámicamente aquí -->
                    </div>

                    <button type="submit" class="btn btn-primary">Crear Autodiagnóstico</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('elementos').addEventListener('change', function() {
        const numElementos = parseInt(this.value);
        const elementoFields = document.getElementById('elementoFields');

        // Limpiar campos existentes
        elementoFields.innerHTML = '';

        // Crear campos para el número de elementos seleccionado
        for (let i = 1; i <= numElementos; i++) {
            const div = document.createElement('div');
            div.className = 'mb-3';
            div.innerHTML = `
                <label for="elemento_${i}" class="form-label">Nombre del Elemento ${i}</label>
                <input type="text" name="nombres_elementos[]" class="form-control" required>
                <label for="criterios_${i}" class="form-label">Criterios del Elemento ${i} (1 o más)</label>
                <textarea name="criterios[${i}][]" class="form-control" rows="2" placeholder="Ingrese un criterio..."></textarea>
                <button type="button" class="btn btn-secondary add-criterio" data-elemento="${i}">Agregar Criterio</button>
                <div class="criterioFields_${i}"></div>
            `;
            elementoFields.appendChild(div);

            // Evento para agregar criterios
            div.querySelector('.add-criterio').addEventListener('click', function() {
                const elemento = this.getAttribute('data-elemento');
                const criterioFields = document.querySelector(`.criterioFields_${elemento}`);
                const newCriterioDiv = document.createElement('div');
                newCriterioDiv.className = 'mb-2';
                newCriterioDiv.innerHTML = `
                    <input type="text" name="criterios[${elemento}][]" class="form-control" placeholder="Ingrese un criterio adicional" required>
                    <button type="button" class="btn btn-danger remove-criterio">Eliminar</button>
                `;
                criterioFields.appendChild(newCriterioDiv);

                // Evento para eliminar criterios
                newCriterioDiv.querySelector('.remove-criterio').addEventListener('click', function() {
                    criterioFields.removeChild(newCriterioDiv);
                });
            });
        }
    });
</script>
