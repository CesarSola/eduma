@extends('adminlte::page')

@section('title', 'Formato de Atención a Usuarios')

@section('content_header')
<h1 class="text-center font-weight-bold">Sistema Nacional de Competencia en la operación de la Evaluación y Certificación</h1>
<br>
<p class="text-center font-weight-bold">Formato de Atención a Usuarios</p>
<p class="text-center font-weight-bold">Estándar de Competencia: {{ $estandar_nombre }}</p>
@stop

@section('content')
<div class="container">
    <!-- Formulario para ingresar los datos -->
    <form action="{{ route('formato-atencion.store', $estandar_id) }}" method="POST">
        @csrf

        <h2 class="text-center font-weight-bold">Información del Formulario</h2>
        <table class="table">
            <tbody>
                <tr>
                    <td>Año:</td>
                    <td><input type="text" name="año" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Medio de Contacto:</td>
                    <td>
                        <input type="text" name="presencial" class="form-control" placeholder="Presencial" required>
                    </td>
                    <td>
                        <input type="text" name="celular" class="form-control" placeholder="Celular" required>
                    </td>
                    <td colspan="3">
                        <input type="text" name="correo" class="form-control" placeholder="Correo" required>
                    </td>
                    <td>
                        <input type="text" name="medio_contacto" class="form-control" placeholder="Otro (Escriba el medio)" required>
                    </td>
                </tr>
                <tr>
                    <td>Lugar:</td>
                    <td><input type="text" name="lugar" class="form-control" required></td>
                    <td>Fecha:</td>
                    <td><input type="date" name="fecha" class="form-control" required></td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-center font-weight-bold">DATOS GENERALES DEL USUARIO</h2>
        <table class="table">
            <tbody>
                <tr>
                    <td>Nombre:</td>
                    <td><input type="text" name="nombre" class="form-control"  placeholder="Nombres" required></td>
                </tr>
                <tr>
                    <td>Apellidos:</td>
                    <td><input type="text" name="apellidos" class="form-control"  placeholder="Paternos, Maternos" required></td>
                </tr>
                <tr>
                    <td>Domicilio:</td>
                    <td><input type="text" name="domicilio" class="form-control"  placeholder="(Calle; numero exterior y/o interior)" required></td>
                </tr>
                <tr>
                    <td>Colonia:</td>
                    <td><input type="text" name="colonia" class="form-control" required></td>
                    <td>Código Postal:</td>
                    <td><input type="text" name="codigo_postal" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Delegación o Municipio:</td>
                    <td><input type="text" name="delegacion" class="form-control" required></td>
                    <td>Estado:</td>
                    <td><input type="text" name="estado" class="form-control" required></td>
                </tr>
                <tr>
                    <td>Ciudad:</td>
                    <td><input type="text" name="ciudad" class="form-control" required></td>
                    <td>Fax:</td>
                    <td><input type="text" name="fax" class="form-control"></td>
                </tr>
                <tr>
                    <td>Teléfonos(Incluyendo Clave Lada):</td>
                    <td><input type="text" name="telefono" class="form-control" required></td>
                    <td>E-Mail:</td>
                    <td><input type="email" name="email" class="form-control" required></td>
                </tr>
            </tbody>
        </table>



        <h2 class="text-center font-weight-bold">Cuestionario</h2>
        <p>Estimado usuario, le agradeceremos que conteste el siguiente cuestionario para mejorar nuestro servicio.
            Tache la opción que defina la forma en que recibió la atención.
        </p>
        <table class="table">
            <tbody>
                <tr>
                    <td>¿Cómo califica la atención que se le ha dado?</td>
                    <td>
                        <label><input type="radio" name="calificacion_atencion" value="Bueno" required> Bueno</label>
                        <label><input type="radio" name="calificacion_atencion" value="Regular" required> Regular</label>
                        <label><input type="radio" name="calificacion_atencion" value="Malo" required> Malo</label>
                    </td>
                </tr>
                <tr>
                    <td>¿Considera que el tiempo de atención fue el adecuado?</td>
                    <td>
                        <label><input type="radio" name="tiempo_atencion" value="Bueno" required> Bueno</label>
                        <label><input type="radio" name="tiempo_atencion" value="Regular" required> Regular</label>
                        <label><input type="radio" name="tiempo_atencion" value="Malo" required> Malo</label>
                    </td>
                </tr>
                <tr>
                    <td>¿Considera que se le dio un trato amable?</td>
                    <td>
                        <label><input type="radio" name="trato_amable" value="Bueno" required> Bueno</label>
                        <label><input type="radio" name="trato_amable" value="Regular" required> Regular</label>
                        <label><input type="radio" name="trato_amable" value="Malo" required> Malo</label>
                    </td>
                </tr>
                <tr>
                    <td>¿La persona que le brindó la atención le dio la confianza necesaria?</td>
                    <td>
                        <label><input type="radio" name="confianza_atencion" value="Bueno" required> Bueno</label>
                        <label><input type="radio" name="confianza_atencion" value="Regular" required> Regular</label>
                        <label><input type="radio" name="confianza_atencion" value="Malo" required> Malo</label>
                    </td>
                </tr>
                <tr>
                    <td>¿Para dirigirse a usted la persona utilizó palabras y términos claros?</td>
                    <td>
                        <label><input type="radio" name="comprension_atencion" value="Bueno" required> Bueno</label>
                        <label><input type="radio" name="comprension_atencion" value="Regular" required> Regular</label>
                        <label><input type="radio" name="comprension_atencion" value="Malo" required> Malo</label>
                    </td>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}<br>
            <a href="{{ route('formato-atencion.download', $estandar_id) }}" class="btn btn-info mt-2">Descargar Formato Word</a>
        </div>
    @endif
</div>
@stop
