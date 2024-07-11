@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
@stop

@section('content')

    <x-app-layout>

        <div class="py-12">


        </div>

        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="container-1">
                <div class="container1.1">
                    <!-- Contenedor para la vista previa de la imagen y la etiqueta -->
                    <div class="preview-container mb-4">
                        <x-input-label class="mb-2" for="name" :value="__('Foto de perfil')" />
                        <!-- Vista previa de la imagen -->
                        <img src="{{ $user->foto ? asset($user->foto) : asset('default-avatar.png') }}" id="previewImage"
                            width="200" height="200" class="rounded-full shadow-lg mb-4">
                        <!-- Input para seleccionar una nueva imagen -->
                        <label for="foto"
                            class="cursor-pointer hover:opacity-80 inline-flex items-center shadow-md px-4 py-2 bg-blue-500 text-blue border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Seleccionar imagen
                            <input id="foto" name="foto" type="file" class="text-sm cursor-pointer hidden"
                                onchange="previewFile()" accept="image/*">
                        </label>
                        <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                    </div>
                </div>
            </div>


            <script>
                function previewFile() {
                    const preview = document.getElementById('previewImage');
                    const file = document.getElementById('foto').files[0];
                    const reader = new FileReader();

                    reader.addEventListener("load", function() {
                        // Convert file to base64 string
                        preview.src = reader.result;
                    }, false);

                    if (file) {
                        reader.readAsDataURL(file);
                    }
                }
            </script>

            <div class="container">
                <br>
                <div class="flex-container">

                    <div class="Div-1">
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $user->name)" required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="age" :value="__('Edad')" />
                            <x-text-input id="age" name="age" type="number" class="mt-1 block w-full"
                                :value="old('age', $user->age)" required autofocus autocomplete="age" />
                            <x-input-error class="mt-2" :messages="$errors->get('age')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="calle_avenida" :value="__('Calle o Avenida')" />
                            <x-text-input id="calle_avenida" name="calle_avenida" type="text" class="mt-1 block w-full"
                                :value="old('calle_avenida', $user->calle_avenida)" required autofocus autocomplete="calle_avenida" />
                            <x-input-error class="mt-2" :messages="$errors->get('calle_avenida')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="d_estado" :value="__('Estado')" />
                            <select id="d_estado" name="d_estado"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Selecciona un estado</option>
                                @php
                                    $estados = new \Illuminate\Support\Collection();
                                @endphp
                                @foreach ($codigosPostales as $codigoPostal)
                                    @unless ($estados->contains($codigoPostal->d_estado))
                                        <option value="{{ $codigoPostal->d_estado }}"
                                            {{ $user->d_estado == $codigoPostal->d_estado ? 'selected' : '' }}>
                                            {{ $codigoPostal->d_estado }}</option>
                                        @php
                                            $estados->push($codigoPostal->d_estado);
                                        @endphp
                                    @endunless
                                @endforeach
                            </select>
                        </div>


                    </div>

                    <div class="Div-2">

                        <div class="mb-4">
                            <x-input-label for="secondName" :value="__('Segundo Nombre')" />
                            <x-text-input id="secondName" name="secondName" type="text" class="mt-1 block w-full"
                                :value="old('secondName', $user->secondName)" required autofocus autocomplete="secondName" />
                            <x-input-error class="mt-2" :messages="$errors->get('secondName')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="genero" :value="__('Género')" />
                            <select id="genero" name="genero"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="Hombre" {{ $user->genero === 'Hombre' ? 'selected' : '' }}>Hombre</option>
                                <option value="Mujer" {{ $user->genero === 'Mujer' ? 'selected' : '' }}>Mujer</option>
                                <option value="Prefiero no contestar"
                                    {{ $user->genero === 'Prefiero no contestar' ? 'selected' : '' }}>Prefiero no contestar
                                </option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('genero')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="numext" :value="__('Número Exterior')" />
                            <x-text-input id="numext" name="numext" type="text" class="mt-1 block w-full"
                                :value="old('numext', $user->numext)" required autofocus autocomplete="numext" />
                            <x-input-error class="mt-2" :messages="$errors->get('numext')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="d_ciudad" :value="__('Ciudad')" />
                            <select id="d_ciudad" name="d_ciudad"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Selecciona una ciudad</option>
                                @php
                                    $ciudades = new \Illuminate\Support\Collection();
                                @endphp
                                @foreach ($codigosPostales as $codigoPostal)
                                    @unless ($ciudades->contains($codigoPostal->d_ciudad))
                                        <option value="{{ $codigoPostal->d_ciudad }}"
                                            {{ $user->d_ciudad == $codigoPostal->d_ciudad ? 'selected' : '' }}>
                                            {{ $codigoPostal->d_ciudad }}</option>
                                        @php
                                            $ciudades->push($codigoPostal->d_ciudad);
                                        @endphp
                                    @endunless
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="Div-3">
                        <div class="mb-4">
                            <x-input-label for="paternalSurname" :value="__('Apellido Paterno')" />
                            <x-text-input id="paternalSurname" name="paternalSurname" type="text"
                                class="mt-1 block w-full" :value="old('paternalSurname', $user->paternalSurname)" required autofocus
                                autocomplete="paternalSurname" />
                            <x-input-error class="mt-2" :messages="$errors->get('paternalSurname')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Correo')" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                                :value="old('email', $user->email)" required autofocus autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div class="mb-4">
                            <label for="d_asenta" class="block text-sm font-medium text-gray-700">Colonia:</label>
                            <select id="d_asenta" name="d_asenta"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Selecciona una colonia</option>
                                @foreach ($codigosPostales as $codigoPostal)
                                    <option value="{{ $codigoPostal->d_asenta }}"
                                        {{ $user->d_asenta == $codigoPostal->d_asenta ? 'selected' : '' }}>
                                        {{ $codigoPostal->d_asenta }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="phone" :value="__('Telefono')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />

                        </div>
                    </div>
                    <div class="Div-4">


                        <div class="mb-4">
                            <x-input-label for="maternalSurname" :value="__('Apellido materno')" />
                            <x-text-input id="maternalSurname" name="maternalSurname" type="text"
                                class="mt-1 block w-full" :value="old('maternalSurname', $user->maternalSurname)" required autofocus
                                autocomplete="maternalSurname" />
                            <x-input-error class="mt-2" :messages="$errors->get('maternalSurname')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="codigo_postal" :value="__('Código Postal')" />
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <input type="text" id="codigo_postal" name="codigo_postal"
                                    value="{{ old('codigo_postal', $user->d_codigo) }}" required
                                    class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none row-autounded-md sm:text-sm border-gray-300">
                                <button type="button" id="buscar-btn"
                                    class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md"
                                    style="color: blue">Buscar</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="D_mnpio" class="block text-sm font-medium text-gray-700">Municipio:</label>
                            <select id="D_mnpio" name="D_mnpio"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Selecciona un municipio</option>
                                @php
                                    $municipios = new \Illuminate\Support\Collection();
                                @endphp
                                @foreach ($codigosPostales as $codigoPostal)
                                    @unless ($municipios->contains($codigoPostal->D_mnpio))
                                        <option value="{{ $codigoPostal->D_mnpio }}"
                                            {{ $user->D_mnpio == $codigoPostal->D_mnpio ? 'selected' : '' }}>
                                            {{ $codigoPostal->D_mnpio }}</option>
                                        @php
                                            $municipios->push($codigoPostal->D_mnpio);
                                        @endphp
                                    @endunless
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Agregar campos adicionales al final del formulario -->
                    <div class="Div-5">
                        <div class="mb-4">
                            <x-input-label for="curp" :value="__('CURP')" />
                            <x-text-input id="curp" name="curp" type="text" class="mt-1 block w-full"
                                :value="old('curp', $user->curp)" required autofocus autocomplete="curp"
                                oninput="this.value = this.value.toUpperCase()" />
                            <x-input-error class="mt-2" :messages="$errors->get('curp')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="nacionalidad" :value="__('Nacionalidad')" />
                            <x-text-input id="nacionalidad" name="nacionalidad" type="text" class="mt-1 block w-full"
                                :value="old('nacionalidad', $user->nacionalidad)" required autofocus autocomplete="nacionalidad" />
                            <x-input-error class="mt-2" :messages="$errors->get('nacionalidad')" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="nacimiento" :value="__('Fecha de Nacimiento')" />
                            <x-text-input id="nacimiento" name="nacimiento" type="date" class="mt-1 block w-full"
                                :value="old('nacimiento', $user->nacimiento)" required autofocus autocomplete="nacimiento" />
                            <x-input-error class="mt-2" :messages="$errors->get('nacimiento')" />
                        </div>
                    </div>

                </div>
                <br>
                <div class="flex items-center justify-between gap-4">
                    <!-- Botón "Guardar" -->
                    <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                    <!-- Mensaje de guardado -->
                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Guardado.') }}</p>
                    @endif

                    <!-- Botón "Cambiar contraseña" -->
                    <button type="button" class="btn btn-success md:w-auto" data-toggle="modal"
                        data-target="#exampleModalCenter">
                        Cambiar contraseña
                    </button>
                </div>
            </div>

        </form>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Update Password') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </header>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('profile.partials.update-password-form')
                    </div>

                </div>
            </div>
        </div>

        </div>

        </div>
        </div>
        <br>
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </x-app-layout>
@stop
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .container {
            background-color: white;
            width: 100%;
            padding: 50px;
            border-radius: 10px;
        }

        .container-1 {
            background-color: white;
            width: 60%;
            /* Ancho reducido al 60% para dejar 20% de margen en cada lado */
            padding: 10px;
            border-radius: 10px;
            margin: 0 auto;
            /* Centrado horizontal */
            display: flex;
            justify-content: center;
            /* Centra el contenido horizontalmente */
            align-items: center;
            /* Centra el contenido verticalmente */
        }

        .container1.1 {
            display: flex;
            flex-direction: column;
            /* Organizar en columna */
            align-items: center;
            /* Centrar horizontalmente los elementos */
            width: 100%;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        button {
            margin-top: 20px;
        }



        .flex-container {
            display: flex;
            padding: 20px;
            margin-left: 55px;
        }

        .Div-1 {
            margin-left: 10px;
        }

        .Div-2 {
            margin-left: 55px;
        }

        .Div-3 {
            margin-left: 55px;
        }

        .Div-4 {
            margin-left: 55px;
        }

        .Div-5 {
            margin-left: 55px;
        }
    </style>
@stop

@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function nextStep() {
            // Oculta la sección de personal y muestra la de información adicional
            document.getElementById("personal-section").style.display = "none";
            document.getElementById("additional-info-section").style.display = "block";

            // Actualiza el progreso
            document.querySelector('.progress-bar').style.width = '100%';
            document.querySelector('.progress-bar').innerHTML = 'Ubicación';
        }

        function goBack() {
            // Oculta la sección de información adicional y muestra la de personal
            document.getElementById("additional-info-section").style.display = "none";
            document.getElementById("personal-section").style.display = "block";

            // Actualiza el progreso
            document.querySelector('.progress-bar').style.width = '50%';
            document.querySelector('.progress-bar').innerHTML = 'Cuenta';
        }

        $(document).ready(function() {
            $('#next-btn').click(function() {
                // Validación de los campos del primer paso (puedes agregar más validaciones si es necesario)
                var name = $('input[name="name"]').val();
                var email = $('input[name="email"]').val();
                var password = $('input[name="password"]').val();
                var password_confirmation = $('input[name="password_confirmation"]').val();

                if (name && email && password && password === password_confirmation) {
                    $('#personal-section').hide();
                    $('#additional-info-section').show();
                } else {
                    alert('Por favor, completa todos los campos correctamente.');
                }
            });

            $('#buscar-btn').click(function() {
                var codigoPostal = $('#codigo_postal').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('obtener-detalles-codigo-postal') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        codigo_postal: codigoPostal
                    },
                    success: function(response) {
                        if (response.codigosPostales) {
                            var coloniaSelect = $('#d_asenta');
                            var municipioSelect = $('#D_mnpio');
                            var estadoSelect = $('#d_estado');
                            var ciudadSelect = $('#d_ciudad');

                            coloniaSelect.empty().append(
                                '<option value="">Selecciona una colonia</option>');
                            municipioSelect.empty().append(
                                '<option value="">Selecciona un municipio</option>');
                            estadoSelect.empty().append(
                                '<option value="">Selecciona un estado</option>');
                            ciudadSelect.empty().append(
                                '<option value="">Selecciona una ciudad</option>');

                            var municipiosUnicos = new Set();
                            var estadosUnicos = new Set();
                            var ciudadesUnicas = new Set();

                            var primerLugar = response.codigosPostales[0];

                            coloniaSelect.append('<option value="' + primerLugar.d_asenta +
                                '" selected>' + primerLugar.d_asenta + '</option>');
                            municipioSelect.append('<option value="' + primerLugar.D_mnpio +
                                '" selected>' + primerLugar.D_mnpio + '</option>');
                            estadoSelect.append('<option value="' + primerLugar.d_estado +
                                '" selected>' + primerLugar.d_estado + '</option>');
                            ciudadSelect.append('<option value="' + primerLugar.d_ciudad +
                                '" selected>' + primerLugar.d_ciudad + '</option>');

                            municipiosUnicos.add(primerLugar.D_mnpio);
                            estadosUnicos.add(primerLugar.d_estado);
                            ciudadesUnicas.add(primerLugar.d_ciudad);

                            $.each(response.codigosPostales, function(index, lugar) {
                                if (index !== 0) {
                                    coloniaSelect.append('<option value="' + lugar
                                        .d_asenta + '">' + lugar.d_asenta +
                                        '</option>');

                                    if (!municipiosUnicos.has(lugar.D_mnpio)) {
                                        municipioSelect.append('<option value="' + lugar
                                            .D_mnpio + '">' + lugar.D_mnpio +
                                            '</option>');
                                        municipiosUnicos.add(lugar.D_mnpio);
                                    }
                                    if (!estadosUnicos.has(lugar.d_estado)) {
                                        estadoSelect.append('<option value="' + lugar
                                            .d_estado + '">' + lugar.d_estado +
                                            '</option>');
                                        estadosUnicos.add(lugar.d_estado);
                                    }
                                    if (!ciudadesUnicas.has(lugar.d_ciudad)) {
                                        ciudadSelect.append('<option value="' + lugar
                                            .d_ciudad + '">' + lugar.d_ciudad +
                                            '</option>');
                                        ciudadesUnicas.add(lugar.d_ciudad);
                                    }
                                }
                            });
                        } else {
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error al obtener los detalles: ' + textStatus);
                    }
                });
            });
        });
    </script>
@stop
