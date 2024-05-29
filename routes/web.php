<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CompetenciasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\ExpedientesController;
use App\Http\Controllers\ExpedientesUsuariosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColoniaController;
use Illuminate\Support\Facades\Route;

use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\callback;
use App\Http\Controllers\PostalCodeController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/colonias', [PostalCodeController::class, 'index']);
//
Route::get('/google-auth/redirect', [GoogleController::class, 'redirect'])
    ->name('auth.redirect');

Route::get('/google-auth/callback', [GoogleController::class, 'callback'])
    ->name('auth.callback');

Route::post('/buscar-colonia', [ColoniaController::class, 'buscarColonia']);

//
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/expedientesAdmin', [ExpedientesController::class, 'index'])->name('expedientesAdmin.index');
Route::get('/usuarios/expediente', [ExpedientesUsuariosController::class, 'index'])->name('usuarios.index');
Route::get('/registroGeneral/expediente', [DocumentosController::class, 'index'])->name('registroGeneral.index');
Route::get('/cursos/expediente', [CursosController::class, 'index'])->name('cursos.index');
Route::get('/competencias/expediente', [CompetenciasController::class, 'index'])->name('competencias.index');

Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);
