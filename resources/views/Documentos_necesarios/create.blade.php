<!-- Modal -->
<section></section>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLabel">Crear nuevo documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="p-4 md:p-5" action="{{ route('documentosnec.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                        <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nombre" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripción</label>
                        <textarea id="description" name="description" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Descripción" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="documentos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documento</label>
                        <input type="file" id="documentos" name="documentos" accept=".pdf" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" onchange="previewPDF(event, 'pdfPreview')" required>
                        <small id="helper-text-explanation" class="text-gray-500 text-sm">Selecciona un archivo PDF.</small>
                    </div>

                    <div class="form-group">
                        <label for="pdfPreview" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Previsualización de PDF</label>
                        <iframe id="pdfPreview" class="hidden pdf-preview" style="width: 100%; height: 300px; border: 1px solid #ccc;"></iframe>
                    </div>

                    <button type="submit" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Guardar</button>
                    <button type="button" class="block text-gray-500 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-3 text-center" data-dismiss="modal">Cerrar</button>
                </form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function previewPDF(event, previewId) {
        var output = document.getElementById(previewId);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.classList.remove('hidden');
        output.style.display = 'block';
    }
</script>
