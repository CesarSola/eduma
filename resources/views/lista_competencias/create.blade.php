<!-- Modal -->
<section>

</section>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="create" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create">Crear nuevo documento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="p-4 md:p-5" action="{{ route('documentosnec.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ old('tipo') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="documentosnec_id">Estandar de Competencia</label>
                        @foreach ($documentosnec as $estandar)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="documentosnec_id[]" value="{{ $estandar->id }}" id="estandar{{ $estandar->id }}">
                                <label class="form-check-label" for="estandar{{ $estandar->id }}">
                                    {{ $estandar->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
