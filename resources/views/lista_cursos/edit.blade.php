<section>

                <!-- Vista para editar un curso -->
                <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre del Curso</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $curso->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <textarea class="form-control" id="description" name="description" required>{{ $curso->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="competencia">Estandares</label>
                          <select class="form-control" id="estandar_id" name="id_estandar" required>

                            @foreach ($estandares as $estandar)
                                <option value="{{ $estandar->id }}">{{ $estandar->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="instructor">Instructor</label>
                        <input type="text" class="form-control" id="instructor" name="instructor" value="{{ $curso->instructor }}">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="duration">Duración (en horas)</label>
                            <input type="number" class="form-control" id="duration" name="duration" value="{{ $curso->duration }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" id="modalidad" name="modalidad">
                                <option value="">Selecciona una modalidad</option>
                                <option value="Online" {{ $curso->modalidad == 'Online' ? 'selected' : '' }}>Online</option>
                                <option value="Presencial" {{ $curso->modalidad == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="Híbrido" {{ $curso->modalidad == 'Híbrido' ? 'selected' : '' }}>Híbrido</option>
                                <!-- Agrega más opciones según sea necesario -->
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fecha_inicio">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ $curso->fecha_inicio }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fecha_final">Fecha Final</label>
                            <input type="date" class="form-control" id="fecha_final" name="fecha_final" value="{{ $curso->fecha_final }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="text" class="form-control" id="costo" name="costo" value="{{ $curso->costo }}">
                    </div>
                    <div class="form-group">
                        <label for="certification">Certificación</label>
                        <input type="text" class="form-control" id="certification" name="certification" value="{{ $curso->certification }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </form>

</section>
