
<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del perfil') }}
        </h2>
    </header>


    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')



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

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Actualizar') }}</x-primary-button>

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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
