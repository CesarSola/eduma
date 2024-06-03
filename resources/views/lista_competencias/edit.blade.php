<section>
    <form id="editForm" action="{{ route('competenciasAD.update', $competencias->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="numero">Numero</label>
            <input type="text" class="form-control" id="numero" name="numero" value="{{ $competencias->numero }}" required>
        </div>
        <div class="form-group">
            <label for="name">Nombre de la Competencia</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $competencias->name }}" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $competencias->tipo }}" required>
        </div>
        <div class="form-group">
            <label for="Dnecesarios">Datos necesarios</label>
            <textarea class="form-control" id="Dnecesarios" name="Dnecesarios" rows="3" required>{{ $competencias->Dnecesarios }}</textarea>
            <small id="DnecesariosHelp" class="form-text text-muted">Ingresa los datos necesarios, separados por comas u otro delimitador.</small>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('competenciasAD.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</section>
