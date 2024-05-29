<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        // Realizar la solicitud a la API
        $response = Http::get('https://api.copomex.com/query/get_colonia_por_cp/97830?token=1a1e01a4-11bd-4a5d-a9b5-fe563db704ea');

        // Obtener los datos JSON de la respuesta
        $data = $response->json();

        // Pasar los datos a la vista 'profile.partials.update-information-form-blade'
        return view('profile.partials.update-information-form-blade', compact('data'));
    }

    public function edit(Request $request): View
    {
        $user = auth()->user();

        // Obtener el código postal del usuario
        $codigoPostal = $user->codpos;

        // Realizar la solicitud a la API para obtener las colonias
        $response = Http::get("https://api.copomex.com/query/get_colonia_por_cp/{$codigoPostal}?token=1a1e01a4-11bd-4a5d-a9b5-fe563db704ea");

        // Obtener los datos JSON de la respuesta
        $data = $response->json();

        // Pasar los datos a la vista 'profile.edit'
        return view('profile.edit', compact('data', 'user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validar los datos del formulario principal
        $validatedData = $request->validated();

        // Agregar reglas de validación para la información adicional
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'calle_avenida' => 'nullable|string|max:255',
            'numext' => 'nullable|string|max:255',
            'codpos' => 'nullable|string|max:10',
            'colonia' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'municipio' => 'nullable|string|max:255',
        ]);

        // Obtener el usuario actual
        $user = $request->user();

        // Actualizar los campos del usuario
        $user->fill($validated);

        // Si el email ha sido modificado, establece email_verified_at a null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardar los cambios
        $user->save();

        // Redireccionar a la página de edición de perfil
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
