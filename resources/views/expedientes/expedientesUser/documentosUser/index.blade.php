<!-- Modal -->
<div class="modal fade" id="documentosModal" tabindex="-1" role="dialog" aria-labelledby="documentosModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="documentosModalLabel">Subir Documentos</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('documentosUser.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="foto" class="font-weight-bold">Fotografía digital:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="foto" name="foto"
                                accept="image/jpeg,image/png,image/bmp" required
                                onchange="previewImage(event, 'foto-preview')">
                            <label class="custom-file-label" for="foto">Seleccionar archivo...</label>
                        </div>
                        <img id="foto-preview" src="#" alt="Vista previa de la foto" class="img-thumbnail mt-3"
                            style="display:none; width: 200px; height: auto;" />
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato JPEG, PNG, o
                            BMP.</small>
                    </div>

                    <div class="form-group">
                        <label for="ine_ife" class="font-weight-bold">Identificación oficial (INE o IFE):</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="ine_ife" name="ine_ife"
                                accept="application/pdf" required onchange="previewPDF(event, 'ine_ife-preview')">
                            <label class="custom-file-label" for="ine_ife">Seleccionar archivo...</label>
                        </div>
                        <embed id="ine_ife-preview" src="#" type="application/pdf" class="mt-3 border rounded"
                            style="display:none; width: 100%; height: 200px;" />
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF.</small>
                    </div>

                    <div class="form-group">
                        <label for="comprobante_domiciliario" class="font-weight-bold">Comprobante domiciliario:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="comprobante_domiciliario"
                                name="comprobante_domiciliario" accept="application/pdf" required
                                onchange="previewPDF(event, 'comprobante_domiciliario-preview')">
                            <label class="custom-file-label" for="comprobante_domiciliario">Seleccionar
                                archivo...</label>
                        </div>
                        <embed id="comprobante_domiciliario-preview" src="#" type="application/pdf"
                            class="mt-3 border rounded" style="display:none; width: 100%; height: 200px;" />
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF.</small>
                    </div>

                    <div class="form-group">
                        <label for="curp" class="font-weight-bold">CURP:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="curp" name="curp"
                                accept="application/pdf" required onchange="previewPDF(event, 'curp-preview')">
                            <label class="custom-file-label" for="curp">Seleccionar archivo...</label>
                        </div>
                        <embed id="curp-preview" src="#" type="application/pdf" class="mt-3 border rounded"
                            style="display:none; width: 100%; height: 200px;" />
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF.</small>
                    </div>

                    <button type="submit" class="btn btn-success btn-block mt-4">Subir documentos</button>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById(previewId);
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function previewPDF(event, previewId) {
        var output = document.getElementById(previewId);
        output.src = URL.createObjectURL(event.target.files[0]);
        output.classList.add('pdf-preview');
        output.style.display = 'block';
    }
</script>
