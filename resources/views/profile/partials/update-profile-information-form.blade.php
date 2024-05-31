<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información de la cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="photo" :value="__('Foto')" />
            <input type="file" class="form-input-file" id="photo" name="photo" accept="image/*" onchange="previewImage(event)">

            @if($user->image)
            <div class="flex items-center mt-2">
                <div>
                    <x-input-label for="photo" :value="__('Foto actual')" class="text-center"/>
                    <div>
                        <img id="photo-preview" src="{{ asset('storage/' . $user->image->path) }}" class="w-24 h-24 rounded-full object-cover">
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">{{ basename($user->image->path) }}</p>
                </div>
            </div>
            @endif

            <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
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

        <!-- Additional Fields -->
        <div>
            <x-input-label for="calle_avenida" :value="__('Calle/Avenida')" />
            <x-text-input id="calle_avenida" name="calle_avenida" type="text" class="mt-1 block w-full" :value="old('calle_avenida', $user->calle_avenida)" />
            <x-input-error class="mt-2" :messages="$errors->get('calle_avenida')" />
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-input-label for="numext" :value="__('No.Ext')" />
                <x-text-input id="numext" name="numext" type="text" class="mt-1 block w-full" :value="old('numext', $user->numext)" />
                <x-input-error class="mt-2" :messages="$errors->get('numext')" />
            </div>

            <div>
                <x-input-label for="codpos" :value="__('Código')" />
                <x-text-input id="codpos" name="codpos" type="text" class="mt-1 block w-full" maxlength="10" :value="old('codpos', $user->codpos)" />
                <x-input-error class="mt-2" :messages="$errors->get('codpos')" />
            </div>
        </div>

       <div class="grid grid-cols-2 gap-6">
            <div>
                <x-input-label for="colonia" :value="__('Colonia')" />
                @if(!empty($data['response']['colonia']))
                <select>
                    @foreach($data['response']['colonia'] as $colonia)
                        <option>{{ $colonia }}</option>
                    @endforeach
                </select>
                @else
                    <p>No se encontraron colonias para este código postal.</p>
                @endif
                <x-input-error class="mt-2" :messages="$errors->get('colonia')" />
            </div>
            <div>
                <x-input-label for="estado" :value="__('Estado')" />
                <x-text-input id="estado" name="estado" type="text" class="mt-1 block w-full" :value="old('estado', $user->estado)" />
                <x-input-error class="mt-2" :messages="$errors->get('estado')" />
            </div>
       </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <x-input-label for="ciudad" :value="__('Ciudad')" />
                <x-text-input id="ciudad" name="ciudad" type="text" class="mt-1 block w-full" :value="old('ciudad', $user->ciudad)" />
                <x-input-error class="mt-2" :messages="$errors->get('ciudad')" />
            </div>

            <div>
                <x-input-label for="municipio" :value="__('Delegación/Municipio')" />
                <x-text-input id="municipio" name="municipio" type="text" class="mt-1 block w-full" :value="old('municipio', $user->municipio)" />
                <x-input-error class="mt-2" :messages="$errors->get('municipio')" />
            </div>
        </div>
        <!-- End of Additional Fields -->

        <!-- Botón para abrir el modal de cambio de contraseña -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('photo-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
