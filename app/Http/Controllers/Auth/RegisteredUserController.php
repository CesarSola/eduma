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
use Spatie\Permission\Models\Role; // Importar el modelo Role

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
            'secondName' => ['required', 'string', 'max:255'],
            'paternalSurname' => ['required', 'string', 'max:255'],
            'maternalSurname' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'codigo_postal' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'genero' => ['required', 'string', 'in:Hombre,Mujer,Otro'],
            // Añadir más validaciones según sea necesario
        ]);

        // Generar matrícula automáticamente
        $matricula = User::generateMatricula();

        // Crear el usuario con todos los campos necesarios incluyendo matrícula y rol
        $user = User::create([
            'name' => $request->name,
            'secondName' => $request->secondName,
            'paternalSurname' => $request->paternalSurname,
            'maternalSurname' => $request->maternalSurname,
            'age' => $request->age,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'calle_avenida' => $request->calle_avenida,
            'nacimiento' => $request->nacimiento,
            'nacionalidad' => $request->nacionalidad,
            'curp' => $request->curp,
            'numext' => $request->numext,
            'd_asenta' => $request->d_asenta,
            'd_estado' => $request->d_estado,
            'd_ciudad' => $request->d_ciudad,
            'D_mnpio' => $request->D_mnpio,
            'd_codigo' => $request->codigo_postal,
            'phone' => $request->phone,
            'genero' => $request->genero,
            'matricula' => $matricula, // Asignar la matrícula generada
            'rol' => 'User', // Guardar el rol 'User' en el campo rol
        ]);

        // Asignar automáticamente el rol 'User' al usuario creado
        $user->assignRole('User');

        // Evento de registro
        event(new Registered($user));

        // Iniciar sesión automáticamente después de registrar al usuario
        Auth::login($user);

        // Redirigir al dashboard u otra página después del registro
        return redirect(route('usuarios.index', absolute: false));
    }
}
