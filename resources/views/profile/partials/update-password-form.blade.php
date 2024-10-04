<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="update_password_current_password" class="form-label">{{ __('Contraseña Actual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password">
            @error('current_password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password" class="form-label">{{ __('Contraseña Nueva') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password">
            @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation"
                class="form-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password">
            @error('password_confirmation')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <br>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-success">{{ __('Actualizar') }}</p>
            @endif
        </div>
    </form>
</section>
