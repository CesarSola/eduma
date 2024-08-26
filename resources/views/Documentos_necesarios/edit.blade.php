<form class="p-4 md:p-5" id="editForm" action="{{ route('documentosnec.update', $documento->id) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-group mb-4">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la
            Competencia</label>
        <input type="text" id="name" name="name"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            value="{{ $documento->name }}" required>
    </div>

    <div class="form-group mb-4">
        <label for="description"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
        <textarea id="description" name="description" rows="4"
            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Escribe la descripción aquí" required>{{ $documento->description }}</textarea>
    </div>

    <div class="form-group mb-4">
        <label for="documento" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documento
            actual</label>
        @if (Str::endsWith($documento->documento, '.pdf'))
            <object data="{{ Storage::url($documento->documento) }}" type="application/pdf" width="100%"
                height="300px">
                <embed src="{{ Storage::url($documento->documento) }}" type="application/pdf" width="100%"
                    height="300px" />
            </object>
        @else
            <p class="text-sm text-gray-600">El documento actual no es un PDF válido.</p>
        @endif
        <input type="file" id="documento" name="documento" accept=".pdf"
            class="mt-2 block text-sm p-2.5 text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        <p class="text-sm text-gray-600 mt-1">Sube un nuevo archivo PDF si deseas actualizar el documento.</p>
    </div>
    <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success me-2">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
    </div>
</form>

<script>
    function closeModal() {
        $('#editModal').modal('hide');
    }
</script>
