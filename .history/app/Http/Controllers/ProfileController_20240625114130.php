<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\CodigoPostal;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $codigosPostales = CodigoPostal::all(); // Obtener todos los códigos postales
        return view('profile.edit', [
            'user' => $request->user(),
            'codigosPostales' => $codigosPostales, // Pasar los códigos postales a la vista
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Actualizar los campos de perfil del usuario
        $user->fill($request->validated());

        $user->secondName = $request->input('secondName');
        $user->paternalSurname = $request->input('paternalSurname');
        $user->maternalSurname = $request->input('maternalSurname');
        $user->calle_avenida = $request->input('calle_avenida');
        $user->numext = $request->input('numext');
        $user->d_codigo = $request->input('d_codigo');
        $user->d_asenta = $request->input('d_asenta');
        $user->d_estado = $request->input('d_estado');
        $user->d_ciudad = $request->input('d_ciudad');
        $user->D_mnpio = $request->input('D_mnpio');
        $user->age = $request->input('age');
        $user->genero = $request->input('genero');
        $user->phone = $request->input('phone');

        // Si se actualizó el email, restablecer la verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Crear un nombre de usuario único para la carpeta de almacenamiento de la foto
        $userName = str_replace(' ', '', $user->name . '' . $user->paternalSurname);

        // Validar y almacenar la fotografía digital si se ha enviado una
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->storeAs('public/images/users/' . $userName, 'Foto.' . $foto->extension());
            $user->foto = $fotoPath;
        }
// Validar y almacenar la fotografía digital si se ha enviado una
if ($request->hasFile('foto')) {
    $foto = $request->file('foto');

    // Generar un nombre de archivo único basado en la fecha actual
    $fileName = date('mdY') . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();

    // Usar el método storeAs y especificar el disco 'public'
    $fotoPath = $foto->storeAs('public/images/profiles/' . $userName, $fileName);

    // Registrar la ruta para depuración
    Log::info('Foto almacenada en: ' . $fotoPath);

    // Verificar si el archivo fue almacenado correctamente
    if (Storage::exists($fotoPath)) {
        $user->foto = str_replace('public/', 'storage/', $fotoPath);
    } else {
        Log::error('No se pudo almacenar la foto en: ' . $fotoPath);
    }
}
        // Guardar los cambios en la base de datos
        $user->save();

        // Redirigir de vuelta al formulario de edición de perfil con un mensaje de éxito
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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

    public function deactivate(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeactivation', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        $user->active = false;
        $user->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'Account deactivated successfully.');
    }

    public function reactivate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'The provided email does not match our records.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        $user->active = true;
        $user->save();

        Auth::login($user);

        return Redirect::to('/dashboard')->with('status', 'Account reactivated successfully.');
    }
    }
