<section>
    <form id="editForm" action="{{ route('documentosnec.update', $documentosnec->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="form-group">
            <label for="name">Nombre de la Competencia</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $documentosnec->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Descripcion</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ $documentosnec->description }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('documentosnec.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</section>
