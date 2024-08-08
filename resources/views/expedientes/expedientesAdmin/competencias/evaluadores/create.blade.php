<div class="modal fade" id="createEvaluadorModal" tabindex="-1" role="dialog" aria-labelledby="createEvaluadorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEvaluadorModalLabel">Crear Nuevo Evaluador</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createEvaluadorForm" action="{{ route('evaluadores.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="secondName">Segundo Nombre</label>
                        <input type="text" class="form-control" id="secondName" name="secondName">
                    </div>
                    <div class="form-group">
                        <label for="paternalSurname">Apellido Paterno</label>
                        <input type="text" class="form-control" id="paternalSurname" name="paternalSurname" required>
                    </div>
                    <div class="form-group">
                        <label for="maternalSurname">Apellido Materno</label>
                        <input type="text" class="form-control" id="maternalSurname" name="maternalSurname">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required>
                    </div>
                    <!-- Aquí puedes agregar un campo oculto para el rol si es necesario -->
                    <input type="hidden" name="role" value="Evaluador">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="createEvaluadorForm">Guardar</button>
            </div>
        </div>
    </div>
</div>
