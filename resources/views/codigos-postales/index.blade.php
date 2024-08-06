@extends('adminlte::page')

@section('title', 'Codigos postales')

@section('content_header')
    <script src="https://kit.fontawesome.com/646ac4fad6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha384-xrR6LJoJdBJ5D4qz7f8K94JPPIU5xN9xnecb76WywRJ2OLqFz1EGgM5V1WQ1gXQQ" crossorigin="anonymous">

    <h1>Codigos postales</h1>
@stop

@section('content')

    <form action="{{ route('importar.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="archivo_excel">Seleccione un archivo Excel:</label>
            <input type="file" class="form-control-file" id="archivo_excel" name="archivo_excel">
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
    <div class="card-body px-0 pb-2">
        <table class="table table-bordered">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Código Postal</th>
                    <th>Asentamiento</th>
                    <th>Tipo Asentamiento</th>
                    <th>Delegacion/Municipio</th>
                    <th>Estado</th>
                    <th>Cuidad</th>
                    <th>Código Administración Postal</th>
                    <th>Clave Entidad</th>
                    <th>Código Administración Postal</th>
                    <th>Clave Tipo de Asentamiento</th>
                    <th>Clave Municipio</th>
                    <th>Identificador único del asentamiento</th>
                    <th>Zona</th>
                    <th>Clave Ciudad</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($codigosPostales as $codigoPostal)
                    <tr>
                        <td>{{ $codigoPostal->id }}</td>
                        <td>{{ $codigoPostal->d_codigo }}</td>
                        <td>{{ $codigoPostal->d_asenta }}</td>
                        <td>{{ $codigoPostal->d_tipo_asenta }}</td>
                        <td>{{ $codigoPostal->D_mnpio }}</td>
                        <td>{{ $codigoPostal->d_estado }}</td>
                        <td>{{ $codigoPostal->d_ciudad }}</td>
                        <td>{{ $codigoPostal->d_CP }}</td>
                        <td>{{ $codigoPostal->c_estado }}</td>
                        <td>{{ $codigoPostal->c_oficina }}</td>
                        <td>{{ $codigoPostal->c_tipo_asenta }}</td>
                        <td>{{ $codigoPostal->c_mnpio }}</td>
                        <td>{{ $codigoPostal->id_asenta_cpcons }}</td>
                        <td>{{ $codigoPostal->d_zona }}</td>
                        <td>{{ $codigoPostal->c_cve_ciudad }}</td>

                    </tr>
                @endforeach
        </table>
    </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                {{-- Anterior --}}
                @if ($codigosPostales->currentPage() > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $codigosPostales->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                @endif

                {{-- Páginas --}}
                @for ($i = 1; $i <= $codigosPostales->lastPage(); $i++)
                    <li class="page-item {{ $codigosPostales->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $codigosPostales->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Siguiente --}}
                @if ($codigosPostales->currentPage() < $codigosPostales->lastPage())
                    <li class="page-item">
                        <a class="page-link" href="{{ $codigosPostales->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#d_codigo').change(function() {
                var codigoPostal = $(this).val();

                $.ajax({
                    url: '/buscar-codigo-postal',
                    method: 'POST',
                    data: {
                        d_codigo: codigoPostal
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#calle_avenida').val(response.calle_avenida);
                        $('#numext').val(response.numext);
                        $('#colonia').val(response.colonia);
                        $('#estado').val(response.estado);
                        $('#ciudad').val(response.ciudad);
                        $('#municipio').val(response.municipio);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@stop