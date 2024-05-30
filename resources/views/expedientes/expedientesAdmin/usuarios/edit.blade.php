<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Datos Generales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ $usuario->name }}" placeholder="Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="secondName" class="form-label">Segundo Nombre:</label>
                        <input type="text" class="form-control" id="secondName" name="secondName"
                            value="{{ $usuario->secondName }}" placeholder="Segundo Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="paternalSurname" class="form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="paternalSurname" name="paternalSurname"
                            value="{{ $usuario->paternalSurname }}" placeholder="Apellido Paterno">
                    </div>
                    <div class="mb-3">
                        <label for="maternalSurname" class="form-label">Apellido Materno:</label>
                        <input type="text" class="form-control" id="maternalSurname" name="maternalSurname"
                            value="{{ $usuario->maternalSurname }}" placeholder="Apellido Materno">
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Edad:</label>
                        <input type="number" class="form-control" id="age" name="age"
                            value="{{ $usuario->age }}" placeholder="Edad">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
            </form>
        </div>
    </div>
</div>
