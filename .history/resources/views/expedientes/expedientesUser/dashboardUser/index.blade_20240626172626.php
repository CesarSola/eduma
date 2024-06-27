@@ -33,6 +33,7 @@

    <br>
    @php
        $documentosSubidos = !$documentos->isEmpty();
        $todosDocumentosValidados = $documentos->isEmpty()
            ? false
            : $documentos->every(function ($documento) {
@@ -46,7 +47,7 @@
            });
    @endphp

    @if (!$todosDocumentosValidados)
    @if (!$documentosSubidos)
        <div class="card">
            <h6 style="text-align: center" class="card-title toggle-card" data-target="#requerimientos">Lista de
                requerimientos y documentación</h6>
@@ -71,72 +72,14 @@
            </div>
        </div>

        @if ($documentos->isEmpty())
            <div class="card">
                <h6 style="text-align: center" class="card-title">Sube tus documentos aquí</h6>
                <br>
                <div class="card-body text-center">
                    <a href="{{ route('documentosUser.index') }}" class="btn btn-primary">Subir documentos</a>
                </div>
            </div>
        @endif
    @endif

    @if ($todosDocumentosValidados)
        <div class="card">
            <h6 style="text-align: center" class="card-title">Estándares de Competencias</h6>
            <h6 style="text-align: center" class="card-title">Sube tus documentos aquí</h6>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Inscríbete a un EC</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="{{ route('competenciaEC.index') }}" class="btn btn-primary">Ver competencias</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Mis Competencias</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver mis competencias</a>
                        </div>
                    </div>
                </div>
            <div class="card-body text-center">
                <a href="{{ route('documentosUser.index') }}" class="btn btn-primary">Subir documentos</a>
            </div>
        </div>

        <br>
        <div class="card">
            <h6 style="text-align: center" class="card-title">Cursos</h6>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Inscríbete a un Curso</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver Cursos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Mis Cursos</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver mis cursos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($todosDocumentosValidados)
        <br>
    @elseif (!$todosDocumentosValidados)
        <div class="card">
            <h6 style="text-align: center" class="card-title">Documentos siendo validados</h6>
            <br>
@@ -192,7 +135,60 @@ class="btn btn-warning">Resubir</a>
                </table>
            </div>
        </div>
    @else
        <br>
        <div class="card">
            <h6 style="text-align: center" class="card-title">Estándares de Competencias</h6>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Inscríbete a un EC</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="{{ route('competenciaEC.index') }}" class="btn btn-primary">Ver competencias</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Mis Competencias</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver mis competencias</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="card">
            <h6 style="text-align: center" class="card-title">Cursos</h6>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Inscríbete a un Curso</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver Cursos</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h6 style="text-align: center" class="card-title">Mis Cursos</h6>
                        <br>
                        <div class="card-body text-center">
                            <a href="#" class="btn btn-primary">Ver mis cursos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop

@section('css')
