<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit">Editar estandar de competencia</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Vista para editar un curso -->
                <form action="{{ route('competencias.update', $competencia->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nombre de la Competencia</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $competencia->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $competencia->tipo }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="{{ route('competencias.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
