<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\GoogleController,
    ProfileController,
    ColoniaController,
    ECviewsController,
    PostalCodeController,
    SDocumentosController,
    CodigoPostalController,
    EvidenciasUEControlle,
    ExpedientesUsuariosController,
    EvidenciasCompetenciasController,
    EvidenciasCursosController,
    RegistroECController,
    EvidenciasUEController,
    MisCompetenciasController,
    RegistroCursoController,
    MisCursosController,
    DashboardUserController,
    DocumentosController,
    CompetenciasController,
    CursosController,
    EvidenciasUCControlle,
    ValidarCoPController,
    ValidarCuPController,
    DocumentosEcController,
    CompetenciasAddController,
    DocumentosNecController,
    RoleController,
    PermissionController,
    UserController,
    FormController
};

// Rutas de autenticación y vistas iniciales
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas de autenticación de Google
Route::get('/google-auth/redirect', [GoogleController::class, 'redirect'])->name('auth.redirect');
Route::get('/google-auth/callback', [GoogleController::class, 'callback'])->name('auth.callback');

require __DIR__ . '/auth.php';

// Rutas relacionadas con colonias y códigos postales
Route::get('/colonias', [PostalCodeController::class, 'index']);
Route::post('/buscar-colonia', [ColoniaController::class, 'buscarColonia']);
Route::post('/obtener-detalles-codigo-postal', [CodigoPostalController::class, 'obtenerDetallesCodigoPostal'])->name('obtener-detalles-codigo-postal');
Route::post('/importar-excel', [CodigoPostalController::class, 'importarExcel'])->name('importar.excel');
Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);
Route::resource('codigos-postales', CodigoPostalController::class);

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::post('/profile/reactivate', [ProfileController::class, 'reactivate'])->name('profile.reactivate');
});

Route::get('/profile/reactivate', function () {
    return view('auth.reactivate');
})->name('profile.reactivate');

// Rutas para expedientes y evidencias
Route::resource('registroGeneral', DocumentosController::class);
Route::get('/documentos/{userId}', [DocumentosController::class, 'index'])->name('registroGeneral.index');
Route::put('/registro-general/{id}/update-documento/{documento}', [DocumentosController::class, 'updateDocumento'])->name('registroGeneral.updateDocumento');

// Rutas para cursos, competencias y documentos necesarios
Route::resource('cursos', CursosController::class);
Route::resource('competenciasAD', CompetenciasAddController::class);
Route::resource('ECinfo', ECviewsController::class);
Route::resource('documentos', DocumentosEcController::class);
Route::resource('documentosnec', DocumentosNecController::class);

// Rutas protegidas por permisos específicos
Route::middleware(['auth', 'can:usuariosAdmin.index'])->group(function () {
    Route::resource('usuariosAdmin', ExpedientesUsuariosController::class);
});

Route::middleware(['auth', 'can:competenciasAD.index'])->group(function () {
    Route::resource('competenciasAD', CompetenciasAddController::class);
});

Route::middleware(['auth', 'can:cursos.index'])->group(function () {
    Route::resource('cursos', CursosController::class);
});

Route::middleware(['auth', 'can:codigos-postales.index'])->group(function () {
    Route::resource('codigos-postales', CodigoPostalController::class);
});

// Rutas para validación de comprobantes
Route::resource('validarCoP', ValidarCoPController::class);
Route::put('/validar-cop/{id}/update-comprobante/{documento}', [ValidarCoPController::class, 'updateComprobante'])->name('validarCoP.updateComprobante');

Route::resource('validarCuP', ValidarCuPController::class);
Route::put('/validar-cup/{id}/update-comprobante/{documento}', [ValidarCuPController::class, 'updateComprobante'])->name('validarCuP.updateComprobante');

// Rutas de usuarios y roles
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);

Route::middleware(['auth', 'can:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Rutas de formularios
Route::get('/form', [FormController::class, 'showForm']);
Route::post('/form', [FormController::class, 'submitForm'])->name('submitForm');
Route::get('/form/download', [FormController::class, 'downloadEmptyForm'])->name('downloadEmptyForm');

// Otras rutas
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

Route::resource('usuarios', DashboardUserController::class);

?>
