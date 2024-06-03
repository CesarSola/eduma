<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'], // Añadir validación para apellidos
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'codigo_postal' => ['required', 'string', 'max:255'],
            'd_asenta' => ['required', 'string', 'max:255'],
            'D_mnpio' => ['required', 'string', 'max:255'],
            'd_estado' => ['required', 'string', 'max:255'],
            'd_ciudad' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'in:male,female,other'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name, // Guardar el apellido
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'd_codigo' => $request->codigo_postal,
            'd_asenta' => $request->d_asenta,
            'D_mnpio' => $request->D_mnpio,
            'd_estado' => $request->d_estado,
            'd_ciudad' => $request->d_ciudad,
            'genero' => $request->genero,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
