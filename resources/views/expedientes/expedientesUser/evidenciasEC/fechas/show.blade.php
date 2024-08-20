<!-- resources/views/partials/modal-fechas.blade.php -->
<div class="modal fade" id="modalFechas" tabindex="-1" role="dialog" aria-labelledby="modalFechasLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFechasLabel">Elegir Fecha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('fechas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="fecha_competencia_id" name="fecha_competencia_id">
                    <input type="hidden" id="estandar_id" name="estandar_id" value="{{ $estandar->id }}">

                    <div class="form-group">
                        @foreach ($fechas_competencia as $fecha)
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header">
                                    <span class="selected-status" id="selected-status-{{ $fecha->id }}"></span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex flex-column date-time-section">
                                            <h6 class="card-title mb-1">Fecha:</h6>
                                            <div class="info-value">{{ $fecha->fecha->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="d-flex flex-column date-time-section">
                                            <h6 class="card-title mb-1">Horario:</h6>
                                            @foreach ($fecha->horarios as $horario)
                                                <div class="info-value">{{ $horario->horaFormatted }}</div>
                                            @endforeach
                                        </div>
                                        <div class="d-flex flex-column">
                                            @foreach ($fecha->horarios as $horario)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="horario_id"
                                                        id="horario_{{ $horario->id }}" value="{{ $horario->id }}"
                                                        data-fecha-id="{{ $fecha->id }}">
                                                    <label class="form-check-label" for="horario_{{ $horario->id }}">
                                                        <span class="status-label"
                                                            id="status_{{ $horario->id }}">Elegido</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        background-color: #f9f9f9;
        border: 1px solid #28a745;
        /* Verde */
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .card-header {
        background-color: #e9f5e9;
        /* Verde claro */
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
        font-weight: 500;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .card-body {
        padding: 1rem;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .modal-header {
        background-color: #28a745;
        /* Verde */
        color: #ffffff;
        border-bottom: 1px solid #dee2e6;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 500;
    }

    .form-check-input {
        width: 1.5rem;
        height: 1.5rem;
        margin-right: 0.5rem;
        cursor: pointer;
    }

    .form-check-label {
        display: flex;
        align-items: center;
    }

    .form-check-input:checked {
        background-color: #28a745;
        /* Verde */
        border-color: #28a745;
        /* Verde */
    }

    .form-check-input:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0.75rem;
        height: 0.75rem;
        background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"%3E%3Cpath d="M9 16.2l-4.2-4.2 1.4-1.4L9 13.4l10-10 1.4 1.4L9 16.2z" fill="%23ffffff"/%3E%3C/svg%3E') center/contain no-repeat;
    }

    .status-label {
        font-size: 0.75rem;
        color: #28a745;
        /* Verde */
        margin-left: 0.5rem;
    }

    .selected-status {
        font-size: 0.875rem;
        color: #28a745;
        /* Verde */
    }

    .btn-success {
        background-color: #28a745;
        /* Verde */
        border-color: #28a745;
        /* Verde */
    }

    .btn-success:hover {
        background-color: #1e7e34;
        /* Verde más oscuro */
        border-color: #1e7e34;
        /* Verde más oscuro */
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    /* Nuevo estilo para las secciones de fecha y horario */
    .date-time-section {
        flex: 1;
        padding: 0.5rem;
        margin-right: 0.5rem;
        background-color: #eafaf1;
        /* Verde muy claro */
        border: 1px solid #c3e6cb;
        /* Verde más claro */
        border-radius: 0.25rem;
    }

    .date-time-section h6 {
        font-size: 0.875rem;
        color: #155724;
        /* Verde oscuro */
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .info-value {
        font-size: 0.875rem;
        color: #333;
        /* Gris oscuro para texto */
    }
</style>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.form-check-input').forEach(input => {
        input.addEventListener('change', function() {
            // Clear all selected statuses
            document.querySelectorAll('.selected-status').forEach(status => {
                status.textContent = '';
            });

            // Set the selected status for the current card
            const fechaId = this.getAttribute('data-fecha-id');
            const statusElement = document.getElementById('selected-status-' + fechaId);
            if (statusElement) {
                statusElement.textContent = 'Elegido';
            }

            // Update the hidden input value
            document.getElementById('fecha_competencia_id').value = this.getAttribute('data-fecha-id');
        });
    });
</script>
