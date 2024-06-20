<section>
    <form action="{{ route('competenciasAD.update', $competencia->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="numero">Número</label>
            <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero', $competencia->numero) }}">
        </div>
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $competencia->name) }}" required>
        </div>
        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo', $competencia->tipo) }}" required>
        </div>

        <hr>

        <div class="form-group">
            <label for="documentosnec_id">Estandar de Competencia</label>
            @foreach ($documentosnec as $estandar)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="documentosnec_id[]" value="{{ $estandar->id }}" id="estandar{{ $estandar->id }}"
                        {{ in_array($estandar->id, $competencia->documentosnec->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="estandar{{ $estandar->id }}">
                        {{ $estandar->name }}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

    <hr>


</section>
