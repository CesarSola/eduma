<section>
        <div class="container">
            <h1 class="my-4">Editar Diagnóstico</h1>
            <form action="{{ route('diagnosticos.update', $diagnostico->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" class="form-control" id="codigo" value="{{ $diagnostico->codigo }}" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" value="{{ $diagnostico->nombre }}">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" id="descripcion" required>{{ $diagnostico->descripcion }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('diagnosticos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
</section>

@section('js')
    @parent
    <script>
        function closeModal() {
            $('#editModal').modal('hide');
        }
    </script>
@endsection
