<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informacion de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Apellidos')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Informacion de Domicilio') }}
            </h2>
        
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Sube la informacion de tu direccion.") }}
            </p>
        </header>
        
        <div>
            <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" id="codigo_postal" name="codigo_postal" value="{{ old('codigo_postal', $user->d_codigo) }}" required class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-md sm:text-sm border-gray-300">
                <button type="button" id="buscar-btn" class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md">Buscar</button>
            </div>
        </div>

        <div>
            <label for="d_asenta" class="block text-sm font-medium text-gray-700">Colonia:</label>
            <select id="d_asenta" name="d_asenta" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Selecciona una colonia</option>
                @foreach ($codigosPostales as $codigoPostal)
                    <option value="{{ $codigoPostal->d_asenta }}" {{ $user->d_asenta == $codigoPostal->d_asenta ? 'selected' : '' }}>{{ $codigoPostal->d_asenta }}</option>
                @endforeach
            </select>
        </div>
            <select id="D_mnpio" name="D_mnpio" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" >Selecciona un municipio</option>
                @php
                    $municipios = new \Illuminate\Support\Collection();
                @endphp
                @foreach ($codigosPostales as $codigoPostal)
                    @unless ($municipios->contains($codigoPostal->D_mnpio))
                        <option value="{{ $codigoPostal->D_mnpio }}" {{ $user->D_mnpio == $codigoPostal->D_mnpio ? 'selected' : '' }}>{{ $codigoPostal->D_mnpio }}</option>
                        @php
                            $municipios->push($codigoPostal->D_mnpio);
                        @endphp
                    @endunless
                @endforeach
            </select>
            
            <select id="d_estado" name="d_estado" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Selecciona un estado</option>
                @php
                    $estados = new \Illuminate\Support\Collection();
                @endphp
                @foreach ($codigosPostales as $codigoPostal)
                    @unless ($estados->contains($codigoPostal->d_estado))
                        <option value="{{ $codigoPostal->d_estado }}" {{ $user->d_estado == $codigoPostal->d_estado ? 'selected' : '' }}>{{ $codigoPostal->d_estado }}</option>
                        @php
                            $estados->push($codigoPostal->d_estado);
                        @endphp
                    @endunless
                @endforeach
            </select>
            
            <select id="d_ciudad" name="d_ciudad" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="">Selecciona una ciudad</option>
                @php
                    $ciudades = new \Illuminate\Support\Collection();
                @endphp
                @foreach ($codigosPostales as $codigoPostal)
                    @unless ($ciudades->contains($codigoPostal->d_ciudad))
                        <option value="{{ $codigoPostal->d_ciudad }}" {{ $user->d_ciudad == $codigoPostal->d_ciudad ? 'selected' : '' }}>{{ $codigoPostal->d_ciudad }}</option>
                        @php
                            $ciudades->push($codigoPostal->d_ciudad);
                        @endphp
                    @endunless
                @endforeach
            </select>
            <div>
                <x-input-label for="genero" :value="__('Genero')" />
                <select id="genero" name="genero" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"">
                    <option value="Hombre" {{ $user->genero === 'Hombre' ? 'selected' : '' }}>Hombre</option>
                    <option value="Mujer" {{ $user->genero === 'Mujer' ? 'selected' : '' }}>Mujer</option>
                    <option value="Prefiero no contestar" {{ $user->genero === 'Prefiero no contestar' ? 'selected' : '' }}>Prefiero no contestar</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('genero')" />
            </div>
            
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#buscar-btn').click(function() {
            var codigoPostal = $('#codigo_postal').val();
            
            // Realizar la solicitud AJAX
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

                        coloniaSelect.empty().append('<option value="">Selecciona una colonia</option>'); // Limpiar y agregar la opción predeterminada
                        municipioSelect.empty().append('<option value="">Selecciona un municipio</option>'); // Limpiar y agregar la opción predeterminada
                        estadoSelect.empty().append('<option value="">Selecciona un estado</option>'); // Limpiar y agregar la opción predeterminada
                        ciudadSelect.empty().append('<option value="">Selecciona una ciudad</option>'); // Limpiar y agregar la opción predeterminada

                        var municipiosUnicos = new Set();
                        var estadosUnicos = new Set();
                        var ciudadesUnicas = new Set();

                        var primerLugar = response.codigosPostales[0];

                        coloniaSelect.append('<option value="' + primerLugar.d_asenta + '" selected>' + primerLugar.d_asenta + '</option>'); // Seleccionar la primera opción
                        municipioSelect.append('<option value="' + primerLugar.D_mnpio + '" selected>' + primerLugar.D_mnpio + '</option>'); // Seleccionar la primera opción
                        estadoSelect.append('<option value="' + primerLugar.d_estado + '" selected>' + primerLugar.d_estado + '</option>'); // Seleccionar la primera opción
                        ciudadSelect.append('<option value="' + primerLugar.d_ciudad + '" selected>' + primerLugar.d_ciudad + '</option>'); // Seleccionar la primera opción

                        municipiosUnicos.add(primerLugar.D_mnpio);
                        estadosUnicos.add(primerLugar.d_estado);
                        ciudadesUnicas.add(primerLugar.d_ciudad);

                        $.each(response.codigosPostales, function(index, lugar) {
                            if (index !== 0) {
                                coloniaSelect.append('<option value="' + lugar.d_asenta + '">' + lugar.d_asenta + '</option>'); // Agregar opciones de colonia

                                if (!municipiosUnicos.has(lugar.D_mnpio)) {
                                    municipioSelect.append('<option value="' + lugar.D_mnpio + '">' + lugar.D_mnpio + '</option>'); // Agregar opciones de municipio
                                    municipiosUnicos.add(lugar.D_mnpio);
                                }
                                if (!estadosUnicos.has(lugar.d_estado)) {
                                    estadoSelect.append('<option value="' + lugar.d_estado + '">' + lugar.d_estado + '</option>'); // Agregar opciones de estado
                                    estadosUnicos.add(lugar.d_estado);
                                }
                                if (!ciudadesUnicas.has(lugar.d_ciudad)) {
                                    ciudadSelect.append('<option value="' + lugar.d_ciudad + '">' + lugar.d_ciudad + '</option>'); // Agregar opciones de ciudad
                                    ciudadesUnicas.add(lugar.d_ciudad);
                                }
                            }
                        });
                    } else {
                        console.log(response.error); // Manejar mensaje de error
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error al obtener los detalles: ' + textStatus); // Manejar error de solicitud AJAX
                }
            });
        });
    });
</script>
