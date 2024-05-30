<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CompetenciasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\ExpedientesController;
use App\Http\Controllers\ExpedientesUsuariosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\EvidenciasCompetenciasController;
use App\Http\Controllers\EvidenciasCursosController;
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


Route::get('/expedientesAdmin/cursos/expediente', [CursosController::class, 'index'])->name('cursos.index');
Route::get('/expedientesAdmin/cursos/', [EvidenciasCursosController::class, 'index'])->name('cursos.evidencias');


Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);

//ruta index de expedientes ya no existe
//Route::resource('expedientesAdmin', ExpedientesController::class);
//ruta de la carpeta registroGeneral
Route::resource('registroGeneral', DocumentosController::class);
//ruta de la carpeta usuarios
Route::resource('usuariosAdmin', ExpedientesUsuariosController::class);
//ruta de la carpeta cursos
Route::resource('cursosExpediente', CursosController::class);
Route::resource('cursoEvidencia', EvidenciasCursosController::class);
//ruta de la carpeta competencias
Route::resource('competencias', CompetenciasController::class);
Route::resource('competenciaEvidencias', EvidenciasCompetenciasController::class);


// routes/web.php

Route::resource('cursos', CursosController::class);
