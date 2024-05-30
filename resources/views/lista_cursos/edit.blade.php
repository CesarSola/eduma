<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vista para editar un curso -->
<form action="{{ route('cursos.update', $curso->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Campos de entrada para editar los detalles del curso -->
    <div class="form-group">
        <label for="name">Nombre del Curso</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $curso->name }}" required>
    </div>

    <div class="form-group">
        <label for="description">Descripción</label>
        <textarea class="form-control" id="description" name="description" required>{{ $curso->description }}</textarea>
    </div>

    <div class="form-group">
        <label for="instructor">Instructor</label>
        <input type="text" class="form-control" id="instructor" name="instructor" value="{{ $curso->instructor }}">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="duration">Duración (en horas)</label>
            <input type="number" class="form-control" id="duration" name="duration" value="{{ $curso->duration }}">
        </div>
        <div class="form-group col-md-6">
            <label for="modalidad">Modalidad</label>
            <input type="text" class="form-control" id="modalidad" name="modalidad" value="{{ $curso->modalidad }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="fecha_inicio">Fecha de Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $curso->fecha_inicio }}">
        </div>
        <div class="form-group col-md-6">
            <label for="fecha_final">Fecha Final</label>
            <input type="date" class="form-control" id="fecha_final" name="fecha_final" value="{{ $curso->fecha_final }}">
        </div>
    </div>

    <div class="form-group">
        <label for="plataforma">Plataforma</label>
        <input type="text" class="form-control" id="plataforma" name="plataforma" value="{{ $curso->plataforma }}">
    </div>

    <div class="form-group">
        <label for="costo">Costo</label>
        <input type="text" class="form-control" id="costo" name="costo" value="{{ $curso->costo }}">
    </div>

    <div class="form-group">
        <label for="certification">Certificación</label>
        <input type="text" class="form-control" id="certification" name="certification" value="{{ $curso->certification }}">
    </div>

    <!-- Botones para enviar el formulario y cerrar el modal -->
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</form>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
