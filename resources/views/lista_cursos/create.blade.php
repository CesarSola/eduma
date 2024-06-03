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
                        <label for="competencia">Estandar de competencia</label>
                        <textarea class="form-control" id="competencia" name="competencia" required></textarea>
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
                                <!-- Agrega más opciones según sea necesario -->
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
