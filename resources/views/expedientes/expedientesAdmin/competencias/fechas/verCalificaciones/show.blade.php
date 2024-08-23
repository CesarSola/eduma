<!-- Modal para ver calificaciones -->
@foreach ($usuarios as $usuario)
    @foreach ($usuario->estandares as $estandar)
        <div class="modal fade" id="verCalificacionesModal{{ $usuario->id }}-{{ $estandar->id }}" tabindex="-1"
            role="dialog" aria-labelledby="verCalificacionesModalLabel{{ $usuario->id }}-{{ $estandar->id }}"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verCalificacionesModalLabel{{ $usuario->id }}-{{ $estandar->id }}">
                            Calificaciones para {{ $usuario->name }} - {{ $estandar->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($estandar->calificaciones->isEmpty())
                            <p>No se han asignado calificaciones a este usuario.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Evidencias</th>
                                        <th>Evaluación</th>
                                        <th>Presentación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estandar->calificaciones as $calificacion)
                                        <tr>
                                            <td>{{ $calificacion->evidencias }}</td>
                                            <td>{{ $calificacion->evaluacion }}</td>
                                            <td>{{ $calificacion->presentacion }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach
