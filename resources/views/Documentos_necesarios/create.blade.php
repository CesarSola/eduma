<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create">Crear Nuevo Curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('documentosnec.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
