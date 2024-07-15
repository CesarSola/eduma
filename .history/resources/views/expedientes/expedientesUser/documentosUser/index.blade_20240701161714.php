@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="left-content">
                <div class="text-center">
                    <p>SICE</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <h6 style="text-align: center" class="card-title">Documentos</h6>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('documentosUser.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="foto">Fotografía digital:</label>
                            <input type="file" class="form-control" name="foto" accept="image/jpeg,image/png,image/bmp" required onchange="previewImage(event, 'foto-preview')">
                            <img id="foto-preview" src="#" alt="Vista previa de la foto" style="display:none; width: 200px; height: auto; margin-top: 10px;" />
                        </div>

                        <div class="form-group">
                            <label for="ine_ife">Identificación oficial (INE o IFE):</label>
                            <input type="file" class="form-control" name="ine_ife" accept="application/pdf" required onchange="previewPDF(event, 'ine_ife-preview')">
                            <embed id="ine_ife-preview" src="#" type="application/pdf" width="100%" height="200px" style="display:none; margin-top: 10px;" />
                        </div>

                        <div class="form-group">
                            <label for="comprobante_domiciliario">Comprobante domiciliario:</label>
                            <input type="file" class="form-control" name="comprobante_domiciliario" accept="application/pdf" required onchange="previewPDF(event, 'comprobante_domiciliario-preview')">
                            <embed id="comprobante_domiciliario-preview" src="#" type="application/pdf" width="100%" height="200px" style="display:none; margin-top: 10px;" />
                        </div>

                        <div class="form-group">
                            <label for="curp">CURP:</label>
                            <input type="file" class="form-control" name="curp" accept="application/pdf" required onchange="previewPDF(event, 'curp-preview')">
                            <embed id="curp-preview" src="#" type="application/pdf" width="100%" height="200px" style="display:none; margin-top: 10px;" />
                        </div>

                        <button type="submit" class="btn btn-primary">Subir documentos</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #5cb85c;
            /* Color verde */
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #dff0d8;
            /* Fondo verde claro */
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }

        .text-center {
            color: #000;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .toggle-card {
            cursor: pointer;
        }

        #foto-preview {
            width: 200px;
            height: auto;
        }

        embed.pdf-preview {
            width: 100%;
            height: 200px;
        }
    </style>
@stop

@section('js')
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
@stop
