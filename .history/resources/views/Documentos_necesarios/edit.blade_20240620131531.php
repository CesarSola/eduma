<section>
    <form class="p-4 md:p-5" id="editForm" action="{{ route('documentosnec.update', $documentosnec->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-4">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la Competencia</label>
            <input type="text" id="name" name="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                value="{{ $documentosnec->name }}" required>
        </div>

        <div class="form-group mb-4">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
            <textarea id="description" name="description" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Escribe la descripción aquí" required>{{ $documentosnec->description }}</textarea>
        </div>
        <div class="form-group mb-4">
            <label for="documentos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre de la Competencia</label>
            <input type="text" id="documentos" name="documentos"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                value="{{ $documentosnec->documentos }}" required>
        </div>

        <div class="flex justify-between">
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-4">
                Guardar Cambios
            </button>
            <a href="{{ route('documentosnec.index') }}"
                class="text-white bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                Cancelar
            </a>
        </div>
    </form>
</section>
