<?php
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\ECviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostalCodeController;
use App\Http\Controllers\SDocumentosController;
use App\Http\Controllers\EvidenciasUEControlle;
use App\Http\Controllers\ExpedientesUsuariosController;
use App\Http\Controllers\EvidenciasCompetenciasController;
use App\Http\Controllers\EvidenciasCursosController;
use App\Http\Controllers\RegistroECController;
use App\Http\Controllers\EvidenciasUEController;
use App\Http\Controllers\MisCompetenciasController;
use App\Http\Controllers\RegistroCursoController;
use App\Http\Controllers\MisCursosController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\CompetenciasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\EvidenciasUCControlle;
use App\Http\Controllers\ValidarCoPController;
use App\Http\Controllers\ValidarCuPController;
use App\Http\Controllers\DocumentosEcController;
use App\Http\Controllers\CompetenciasAddController;
use App\Http\Controllers\DocumentosNecController;
use App\Http\Controllers\CodigoPostalController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/google-auth/redirect', [GoogleController::class, 'redirect'])->name('auth.redirect');
Route::get('/google-auth/callback', [GoogleController::class, 'callback'])->name('auth.callback');
Route::post('/buscar-colonia', [ColoniaController::class, 'buscarColonia']);
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

Route::resource('codigos-postales', CodigoPostalController::class);
Route::post('/obtener-detalles-codigo-postal', [CodigoPostalController::class, 'obtenerDetallesCodigoPostal'])->name('obtener-detalles-codigo-postal');
Route::post('/importar-excel', [CodigoPostalController::class, 'importarExcel'])->name('importar.excel');
Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');
Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);

Route::resource('registroGeneral', DocumentosController::class);
Route::get('/documentos/{userId}', [DocumentosController::class, 'index'])->name('registroGeneral.index');

Route::middleware(['auth', 'can:usuariosAdmin.index'])->group(function () {
    Route::resource('usuariosAdmin', ExpedientesUsuariosController::class);
});

Route::put('/registro-general/{id}/update-documento/{documento}', [DocumentosController::class, 'updateDocumento'])->name('registroGeneral.updateDocumento');
Route::resource('cursosExpediente', CursosController::class);
Route::resource('evidenciasACU', EvidenciasCursosController::class);
Route::resource('competencia', CompetenciasController::class);
Route::resource('evidenciasACO', EvidenciasCompetenciasController::class);
Route::resource('validarCoP', ValidarCoPController::class);
Route::put('/validar-cop/{id}/update-comprobante/{documento}', [ValidarCoPController::class, 'updateComprobante'])->name('validarCoP.updateComprobante');
Route::resource('validarCuP', ValidarCuPController::class);
Route::put('/validar-cup/{id}/update-comprobante/{documento}', [ValidarCuPController::class, 'updateComprobante'])->name('validarCuP.updateComprobante');
Route::resource('usuarios', DashboardUserController::class);
Route::resource('documentosUser', SDocumentosController::class);
Route::get('/documentosUser/edit/{tipo_documento}', [SDocumentosController::class, 'edit'])->name('documentosUser.edit');
Route::put('/documentosUser/update/{tipo_documento}', [SDocumentosController::class, 'update'])->name('documentosUser.update');
Route::resource('competenciaEC', RegistroECController::class);
Route::resource('registroCurso', RegistroCursoController::class);
Route::resource('miscompetencias', MisCompetenciasController::class);
Route::get('miscompetencias/{id}/mostrar-rechazado', [MisCompetenciasController::class, 'mostrarRechazado'])->name('miscompetencias.resubir_comprobante');
Route::post('miscompetencias/{id}/guardar-resubir-comprobante', [MisCompetenciasController::class, 'guardarResubirComprobante'])->name('miscompetencias.guardarResubirComprobante');
Route::resource('misCursos', MisCursosController::class);
Route::get('misCursos/{id}/mostrar-rechazado', [MisCursosController::class, 'mostrarRechazado'])->name('misCursos.resubir_comprobante');
Route::post('misCursos/{id}/guardar-resubir-comprobante', [MisCursosController::class, 'guardarResubirComprobante'])->name('misCursos.guardarResubirComprobante');
Route::resource('evidenciasEC', EvidenciasUEController::class);
Route::get('/evidenciasEC/{id}/{name}', [EvidenciasUEController::class, 'index'])->name('evidenciasEC.index');
Route::get('/evidencias/{id}/{documento}/show', [EvidenciasUEController::class, 'show'])->name('evidenciasEC.show');
Route::post('/evidencias/{documento}/upload', [EvidenciasUEController::class, 'upload'])->name('evidenciasEC.upload');
Route::resource('evidenciasCU', EvidenciasUCControlle::class);
Route::get('/evidenciasCU/{id}/{name}', [EvidenciasUCControlle::class, 'index'])->name('evidenciasCU.index');
Route::get('/evidenciasCU/{id}/{documento}/show', [EvidenciasUCControlle::class, 'show'])->name('evidenciasCU.show');
Route::post('/evidenciasCU/{documento}/upload', [EvidenciasUCControlle::class, 'upload'])->name('evidenciasCU.upload');
Route::resource('cursos', CursosController::class);
Route::resource('competenciasAD', CompetenciasAddController::class);
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

Route::middleware(['auth', 'can:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
