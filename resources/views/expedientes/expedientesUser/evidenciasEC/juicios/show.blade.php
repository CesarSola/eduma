<!-- Modal -->
<div class="modal fade" id="uploadJuicioModal" tabindex="-1" role="dialog" aria-labelledby="uploadJuicioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-success shadow-sm">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="uploadJuicioModalLabel">Subir Juicio de Competencia</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para subir los juicios de competencia -->
                <form action="{{ route('juicio.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="estandar_id" value="{{ $estandar->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    <div class="form-group mt-2">
                        <label for="nombre">Nombre del Documento:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="Juicio_Competencia_{{ $estandar->name }}_{{ auth()->user()->matricula }}_{{ auth()->user()->name }}_{{ auth()->user()->secondName }}_{{ auth()->user()->paternalSurname }}_{{ auth()->user()->maternalSurname }}"
                            readonly>
                        <small class="form-text text-muted">Asegúrate de firmar tu juicio de Competencia.</small>
                        @error('nombre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mt-2">
                        <label for="file">Selecciona el Documento (PDF):</label>
                        <input type="file" class="form-control-file" id="file" name="file" accept=".pdf"
                            required>
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF.</small>
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mt-2">
                        <label for="pdf-preview">Vista previa del Documento:</label>
                        <div id="pdf-preview" style="width: 100%; height: 300px; border: 1px solid #ddd;"></div>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Subir Juicio de Competencia</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ajustes para el contenedor del PDF */
    #pdf-preview {
        width: 100%;
        height: 300px;
        border: 1px solid #ddd;
        overflow: hidden;
        position: relative;
    }

    /* Ajustes para el canvas */
    #pdf-preview canvas {
        display: block;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
    }
</style>

<head>
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf_viewer.min.css">
</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('file');
        var pdfPreview = document.getElementById('pdf-preview');

        fileInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                console.log('Archivo PDF seleccionado:', file.name);
                var reader = new FileReader();
                reader.onload = function(e) {
                    var pdfData = new Uint8Array(e.target.result);

                    console.log('Datos del PDF cargados');

                    // Cargar y mostrar el PDF
                    pdfjsLib.getDocument({
                        data: pdfData
                    }).promise.then(function(pdf) {
                        console.log('PDF cargado correctamente');
                        pdf.getPage(1).then(function(page) {
                            console.log('Página 1 cargada');
                            var scale = 1.5;
                            var viewport = page.getViewport({
                                scale: scale
                            });

                            var canvas = document.createElement('canvas');
                            var context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;
                            pdfPreview.innerHTML =
                                ''; // Limpiar el contenido anterior
                            pdfPreview.appendChild(canvas);

                            var renderContext = {
                                canvasContext: context,
                                viewport: viewport
                            };
                            page.render(renderContext).promise.then(function() {
                                console.log('Página renderizada');
                                // Ajustar el tamaño del canvas al contenedor
                                var container = pdfPreview
                                    .getBoundingClientRect();
                                var canvasWidth = canvas.width;
                                var canvasHeight = canvas.height;

                                var scaleX = container.width / canvasWidth;
                                var scaleY = container.height /
                                    canvasHeight;
                                var scale = Math.min(scaleX, scaleY);

                                canvas.style.width = (canvasWidth * scale) +
                                    'px';
                                canvas.style.height = (canvasHeight *
                                    scale) + 'px';
                            });
                        });
                    }).catch(function(error) {
                        console.error('Error al cargar el PDF:', error);
                    });
                };
                reader.readAsArrayBuffer(file);
            } else {
                pdfPreview.innerHTML = ''; // Limpiar el contenido si no es un PDF
            }
        });
    });
</script>
