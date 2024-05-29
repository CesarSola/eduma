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
                <form>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="firstName" placeholder="Nombre">
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Apellido">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" class="form-control" id="email" placeholder="Correo electrónico">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between align-items-center" style="height: 38px;">
                    <button type="button" class="btn btn-primary mr-auto">Guardar</button>
                    <button type="button" class="btn btn-danger ml-auto" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
