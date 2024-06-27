<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CompetenciasController;
use App\Http\Controllers\CompetenciasAddController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\DocumentosEcController;
use App\Http\Controllers\DocumentosNecController;
use App\Http\Controllers\ExpedientesUsuariosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\ECviewsController;
use App\Http\Controllers\EvidenciasCompetenciasController;
use App\Http\Controllers\EvidenciasCursosController;
use App\Http\Controllers\RegistroECController;

use Illuminate\Support\Facades\Route;

use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\callback;
use App\Http\Controllers\PostalCodeController;
use App\Http\Controllers\SDocumentosController;

Route::get('/', function () {
    return view('auth.login');
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


use App\Http\Controllers\CodigoPostalController;
use App\Http\Controllers\MisCompetenciasController;

// Rutas para el CRUD de códigos postales
Route::resource('codigos-postales', CodigoPostalController::class);

Route::post('/obtener-detalles-codigo-postal', [CodigoPostalController::class, 'obtenerDetallesCodigoPostal'])->name('obtener-detalles-codigo-postal');



Route::post('/importar-excel', [CodigoPostalController::class, 'importarExcel'])->name('importar.excel');


Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');

Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);

//ruta index de expedientes ya no existe
//Route::resource('expedientesAdmin', ExpedientesController::class);
//ruta de la carpeta registroGeneral
Route::resource('registroGeneral', DocumentosController::class);
//ruta de la carpeta usuarios
Route::resource('usuariosAdmin', ExpedientesUsuariosController::class);
//ruta comentarios-validar
Route::put('/registro-general/{id}/update-documento/{documento}', [DocumentosController::class, 'updateDocumento'])->name('registroGeneral.updateDocumento');
//ruta de la carpeta cursos
Route::resource('cursosExpediente', CursosController::class);
//ruta del show de evidencias cursos
Route::resource('evidenciasCU', EvidenciasCursosController::class);
//ruta de la carpeta competencias
Route::resource('competencia', CompetenciasController::class);
//ruta del show de evidencias competencias
Route::resource('evidenciasCO', EvidenciasCompetenciasController::class);

//rutas del expediente Usuario
//ruta dashboard usuario
Route::resource('usuarios', DashboardUserController::class);
//ruta para subir documentos Usuario
Route::resource('documentosUser', SDocumentosController::class);
Route::get('/documentosUser/edit/{tipo_documento}', [SDocumentosController::class, 'edit'])->name('documentosUser.edit');
Route::put('/documentosUser/update/{tipo_documento}', [SDocumentosController::class, 'update'])->name('documentosUser.update');
//ruta del registro a un EC
Route::resource('competenciaEC', RegistroECController::class);
//ruta de mis competencias
Route::resource('miscompetencias', MisCompetenciasController::class);






// routes/web.php

Route::resource('cursos', CursosController::class);
Route::resource('competenciasAD', CompetenciasAddController::class);
Route::resource('competenciasinscripcion', CompetenciasAddController::class);
Route::resource('ECinfo', ECviewsController::class);
Route::resource('documentos', DocumentosEcController::class);
Route::resource('documentosnec', DocumentosNecController::class);





Route::middleware(['auth'])->group(function () {
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
});

Route::get('/profile/reactivate', function () {
    return view('auth.reactivate');
})->name('profile.reactivate');

Route::post('/profile/reactivate', [ProfileController::class, 'reactivate'])->name('profile.reactivate');



Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::resource('permissions', App\Http\Controllers\PermissionController::class);

Route::middleware(['can:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
});
