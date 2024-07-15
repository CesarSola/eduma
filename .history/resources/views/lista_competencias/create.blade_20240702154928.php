<form class="p-4 md:p-5" action="{{ route('documentos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
    </div>
    <div class="form-group">
        <label for="name">Nombre</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
    </div>
    <div class="form-group">
        <label for="tipo">Tipo</label>
        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo') }}" required>
    </div>
    <div class="form-group">
        <label for="documentosnec_id">Estandar de Competencia</label>
        @foreach ($documentosnec as $estandar)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="documentosnec_id[]" value="{{ $estandar->id }}" id="estandar{{ $estandar->id }}">
                <label class="form-check-label" for="estandar{{ $estandar->id }}">{{ $estandar->name }}</label>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</form>
