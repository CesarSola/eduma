<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-primary shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createLabel">Agregar un Estándar</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="p-4 md:p-5 bg-light rounded" action="{{ route('competenciasAD.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control border-secondary" id="numero" name="numero"
                            value="{{ old('numero') }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control border-secondary" id="name" name="name"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <input type="text" class="form-control border-secondary" id="tipo" name="tipo"
                            value="{{ old('tipo') }}" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="calificacion_minima" class="form-label">Calificación Mínima</label>
                        <input type="number" class="form-control border-secondary" id="calificacion_minima"
                            name="calificacion_minima" value="{{ old('calificacion_minima') }}" step="0.01"
                            min="0" max="100">
                    </div>
                    <div class="form-group mt-3">
                        <label for="documentosnec_id" class="form-label">Estandar de Competencia</label>
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
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success me-2">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
