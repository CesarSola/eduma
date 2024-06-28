<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create">Crear nuevo curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('cursos.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nombre del Curso</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="estandar_id">Estandar de Competencia</label>
                        <select class="form-control" id="estandar_id" name="id_estandar" required>
                            <option value="">Selecciona un estandar</option>
                            @foreach ($estandares as $estandar)
                                <option value="{{ $estandar->id }}">{{ $estandar->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="documentosnec_id">Estandar de Competencia</label>
                        @foreach ($documentosnec as $estandar)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="documentosnec_id[]"
                                    value="{{ $estandar->id }}" id="estandar{{ $estandar->id }}">
                                <label class="form-check-label" for="estandar{{ $estandar->id }}">
                                    {{ $estandar->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor</label>
                        <input type="text" class="form-control" id="instructor" name="instructor">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="duration">Duración (en horas)</label>
                            <input type="number" class="form-control" id="duration" name="duration">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" id="modalidad" name="modalidad">
                                <option value="">Selecciona una modalidad</option>
                                <option value="Online">Online</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_final">Fecha Final</label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="text" class="form-control" id="costo" name="costo">
                    </div>

                    <div class="form-group">
                        <label for="certification">Certificación</label>
                        <input type="text" class="form-control" id="certification" name="certification">
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </form>

            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    // Función para validar las fechas
    function validarFechas() {
        // Obtener los valores de las fechas
        var fechaInicio = document.getElementById('fecha_inicio').value;
        var fechaFinal = document.getElementById('fecha_final').value;

        // Convertir las fechas a objetos Date
        var inicio = new Date(fechaInicio);
        var final = new Date(fechaFinal);

        // Verificar si la fecha de inicio es mayor que la fecha de finalización
        if (inicio > final) {
            // Mostrar un alerta de error
            alert('La fecha de inicio no puede ser mayor que la fecha de finalización');
            // Detener el envío del formulario
            return false;
        }
        // Si las fechas son válidas, permitir el envío del formulario
        return true;
    }

    // Agregar un evento al formulario para llamar a la función validarFechas() antes de enviarlo
    document.getElementById('formulario').addEventListener('submit', function(event) {
        // Llamar a la función validarFechas()
        if (!validarFechas()) {
            // Si la función devuelve false, detener el envío del formulario
            event.preventDefault();
        }
    });
</script>
