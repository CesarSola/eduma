<?php

use App\Http\Controllers\AsignarEvaController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ColoniaController;
use App\Http\Controllers\ECviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostalCodeController;
use App\Http\Controllers\SDocumentosController;
use App\Http\Controllers\DiagnosticoController;
use App\Http\Controllers\Formulario2Controller;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Exception\Exception;

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


// Rutas para el CRUD de códigos postales
use App\Http\Controllers\CodigoPostalController;

Route::get('/buscar-codigo-postal', [PostalCodeController::class, 'buscarCodigoPostal'])->name('buscarCodigoPostal');
Route::resource('codigos-postales', CodigoPostalController::class);
Route::post('/obtener-detalles-codigo-postal', [CodigoPostalController::class, 'obtenerDetallesCodigoPostal'])->name('obtener-detalles-codigo-postal');
Route::post('/importar-excel', [CodigoPostalController::class, 'importarExcel'])->name('importar.excel');
Route::post('/profile/update-address', [ProfileController::class, 'updateAddress'])->name('update-address');
Route::get('/colonias', [PostalCodeController::class, 'getColoniasPorCPColonias']);

//rutas de la carpeta expedientes y sus carpetas
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
use App\Http\Controllers\COResubirController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ElegirFechaController;
use App\Http\Controllers\EvaluadoresController;
use App\Http\Controllers\EvidenciasSubidasController;
use App\Http\Controllers\EvidenciasUCControlle;
use App\Http\Controllers\FechasController;
use App\Http\Controllers\PlanEvaluacionController;
use App\Http\Controllers\ResubirDocumentosController;
use App\Http\Controllers\SubirPlanEvaluacionController;
use App\Http\Controllers\ValidarCartasController;
use App\Http\Controllers\ValidarCoPController;
use App\Http\Controllers\ValidarCuPController;
use App\Http\Controllers\ValidarDocumentosController;
use App\Http\Controllers\ValidarFichasController;
use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\WordController;
use App\Http\Controllers\FormularioController;
//ruta del calendario
Route::resource('calendario', CalendarioController::class);
Route::get('/calendario/{competenciaId}', [CalendarioController::class, 'show'])->name('calendario.show');
//ruta de agregar fechas
Route::post('/competencias/{competencia}/guardar-fechas-modal', [FechasController::class, 'store'])->name('competencias.guardar-fechas-modal');
Route::get('/competencias/{userId}/filtrar-competencias', [FechasController::class, 'filtrarCompetencias']);


//rutas de evaluadores
Route::resource('evaluadores', EvaluadoresController::class);
Route::get('evaluadores/{evaluador}', [EvaluadoresController::class, 'show'])->name('evaluadores.show');
Route::get('asignar-evaluadores', [AsignarEvaController::class, 'index'])->name('asignar.evaluadores');
Route::post('asignar-evaluador', [AsignarEvaController::class, 'store'])->name('asignar.evaluador.store');
Route::get('get-estandares/{userId}', [AsignarEvaController::class, 'getEstandares']);


//ruta index de la carpeta registroGeneral
Route::get('/documentos/{userId}', [DocumentosController::class, 'index'])->name('registroGeneral.index');
Route::get('/documentos/{userId}/show', [DocumentosController::class, 'show'])->name('registroGeneral.show');

//ruta comentarios-validar
Route::put('/registro-general/{id}/update-documento/{documento}', [DocumentosController::class, 'updateDocumento'])->name('registroGeneral.updateDocumento');
//ruta de la carpeta usuarios
Route::resource('usuariosAdmin', ExpedientesUsuariosController::class);
//ruta de la carpeta cursos
Route::resource('cursosExpediente', CursosController::class);
//ruta del show de evidencias cursos
Route::resource('evidenciasACU', EvidenciasCursosController::class);
//ruta de la carpeta competencias
Route::resource('competencia', CompetenciasController::class);
//ruta del show de evidencias competencias
Route::resource('evidenciasACO', EvidenciasCompetenciasController::class);
// Ruta para validar fichas
Route::get('/validar-fichas/{user_id}/{competencia}', [ValidarFichasController::class, 'show'])->name('fichas.show');
// Ruta para actualizar una ficha
Route::put('/validar--fichas/{id}/ficha/{fichaId}', [ValidarFichasController::class, 'updateFicha'])->name('ValidarFicha.updateDocumento');
// Ruta para validar cartas
Route::get('/validar-carta/{user_id}/{competencia}', [ValidarCartasController::class, 'show'])->name('cartas.show');
// Ruta para actualizar una carta
Route::put('/validar--carta/{id}/carta/{cartaId}', [ValidarCartasController::class, 'updateCarta'])->name('ValidarCarta.updateDocumento');
// Ruta para validar documentos
Route::get('/validar-documentos/{user_id}/{competencia_id}', [ValidarDocumentosController::class, 'show'])->name('documentosE.show');
// Ruta para actualizar una documento
Route::put('/validar-documento/{id}/{competencia_id}', [ValidarDocumentosController::class, 'updateDocumento'])->name('ValidarDocumento.updateDocumento');
//ruta de la carpeta validarCoP
Route::resource('validarCoP', ValidarCoPController::class);
// Rutas para validar comprobante de pagos de competencias
Route::put('/validar-cop/{id}/update-comprobante/{documento}', [ValidarCoPController::class, 'updateComprobante'])->name('validarCoP.updateComprobante');
//ruta de la carpeta validarCuP
Route::resource('validarCuP', ValidarCuPController::class);
//rutas para validar comprobante de pagos cursos
Route::put('/validar-cup/{id}/update-comprobante/{documento}', [ValidarCuPController::class, 'updateComprobante'])->name('validarCuP.updateComprobante');

//rutas del expediente Usuario
//ruta dashboard usuario
Route::resource('usuarios', DashboardUserController::class);
//ruta para subir documentos Usuario
Route::resource('documentosUser', SDocumentosController::class);
//rutas para resubir los documentos cuando han sido rechazados
Route::get('/documentosUser/edit/{tipo_documento}', [SDocumentosController::class, 'edit'])->name('documentosUser.editByTipo');
Route::post('/documentosUser/update/{tipo_documento}', [SDocumentosController::class, 'update'])->name('documentosUser.updateByTipo');
//ruta del registro a un EC
Route::resource('competenciaEC', RegistroECController::class);
//ruta del registro de un curso
Route::resource('registroCurso', RegistroCursoController::class);
//ruta de mis competencias
Route::resource('miscompetencias', MisCompetenciasController::class);
//ruta en el cual se muestra si el comprobante de competencias ha sido rechazado(vista usuarios)
Route::get('miscompetencias/{id}/mostrar-rechazado', [COResubirController::class, 'show'])
    ->name('miscompetencias.resubir_comprobante');
//ruta en el cual se sube de nuevo el comprobante si fue rechazado (vista usuarios)
Route::post('miscompetencias/{id}/guardar-resubir-comprobante', [COResubirController::class, 'guardarResubirComprobante'])
    ->name('miscompetencias.guardarResubirComprobante');
Route::get('/ruta/para/obtener/validacion/{id}', [COResubirController::class, 'getValidacion'])->name('getValidacion');
//ruta de mis cursos
Route::resource('misCursos', MisCursosController::class);
//ruta en el cual se muestra si el comprobante de cursos ha sido rechazado(vista usuario)
Route::get('misCursos/{id}/mostrar-rechazado', [MisCursosController::class, 'mostrarRechazado'])
    ->name('misCursos.resubir_comprobante');
//ruta en el cual se sube de nuevo el comprobante si fue rechazado (vista usuarios)
Route::post('misCursos/{id}/guardar-resubir-comprobante', [MisCursosController::class, 'guardarResubirComprobante'])
    ->name('misCursos.guardarResubirComprobante');
//ruta de evidenciasEC
// Route::resource('evidenciasEC', EvidenciasUEController::class);
Route::get('/evidenciasEC/{id}/{name}', [EvidenciasUEController::class, 'index'])->name('evidenciasEC.index');
// Ruta para el formulario del plan de evaluación
Route::get('/plan-evaluacion/{id}', [SubirPlanEvaluacionController::class, 'show'])->name('Plan.show');
// Ruta para almacenar el documento
Route::post('/documentos/store', [SubirPlanEvaluacionController::class, 'store'])->name('plan.store');
Route::get('/evidencias/{id}/{documento_id}/show', [EvidenciasUEController::class, 'show'])->name('evidenciasEC.show');
Route::post('/evidencias/{documento}/upload', [EvidenciasUEController::class, 'upload'])->name('evidenciasEC.upload');
//rutas para resubir documentos de evidencias
Route::get('evidencias/resubir/{id}', [ResubirDocumentosController::class, 'show'])->name('evidencias.resubir');
Route::post('evidencias/resubir/{id}', [ResubirDocumentosController::class, 'resubir'])->name('evidencias.resubir.submit');
//ruta de la vista de evidencias subidas
Route::get('mis-evidencias/{id}/{name}', [EvidenciasSubidasController::class, 'index'])->name('mis.evidencias');
//ruta de elegir fecha
Route::get('/fechas', [ElegirFechaController::class, 'index'])->name('fechas.index');
Route::get('/fechas/{id}', [ElegirFechaController::class, 'show'])->name('fechas.show');
Route::post('/fechas', [ElegirFechaController::class, 'store'])->name('fechas.store');
//ruta evidenciasCU
// Route::resource('evidenciasCU', EvidenciasUCControlle::class);
Route::get('/evidenciasCU/{id}/{name}', [EvidenciasUCControlle::class, 'index'])->name('evidenciasCU.index');
Route::get('/evidenciasCU/{id}/{documento}/show', [EvidenciasUCControlle::class, 'show'])->name('evidenciasCU.show');
Route::post('/evidenciasCU/{documento}/upload', [EvidenciasUCControlle::class, 'upload'])->name('evidenciasCU.upload');
//ruta para generar el autorellenado de documentos word
Route::middleware(['auth'])->group(function () {
    Route::get('/generate-word/{userId}/{standardId}', [WordController::class, 'generateWord'])->name('generate-word');
});
Route::get('/generate-carta/{userId}', [WordController::class, 'generateCarta'])->name('generate-carta');
Route::get('/generate-plan/{userId}/{standardId}', [PlanEvaluacionController::class, 'generatePlan'])->name('generate-plan');
//rutas de para subir ficha de registro y carta firma EC
Route::get('word/{id}/{tipoDocumento}/show', [WordController::class, 'show'])->name('word.show');
Route::post('word/{id}/upload-ficha-registro', [WordController::class, 'uploadFichaRegistro'])->name('word.uploadFichaRegistro');
Route::post('word/{id}/upload-carta-firma', [WordController::class, 'uploadCartaFirma'])->name('word.uploadCartaFirma');

// routes agregar cursos,competencias y documentos necesarios
use App\Http\Controllers\DocumentosEcController;
use App\Http\Controllers\CompetenciasAddController;
use App\Http\Controllers\DocumentosNecController;

Route::resource('cursos', CursosController::class);
Route::resource('competenciasAD', CompetenciasAddController::class);
Route::resource('ECinfo', ECviewsController::class);
Route::resource('documentos', DocumentosEcController::class);
Route::resource('documentosnec', DocumentosNecController::class);
Route::get('/documentos/download/{id}', [DocumentosNecController::class, 'download'])->name('document.download');



Route::get('/profile/reactivate', function () {
    return view('auth.reactivate');
})->name('profile.reactivate');

Route::post('/profile/reactivate', [ProfileController::class, 'reactivate'])->name('profile.reactivatePost');

Route::middleware(['auth'])->group(function () {
    // Ruta para eliminar cuenta
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta para desactivar cuenta
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
});

Route::resource('roles', App\Http\Controllers\RoleController::class);

Route::resource('permissions', App\Http\Controllers\PermissionController::class);

Route::middleware(['can:users.edit'])->group(function () {
    Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
});

Route::get('/users/{user}/assign-diagnostico', [UserController::class, 'assignDiagnostico'])->name('users.assignDiagnostico');
Route::get('/users/diagnosticos', [UserController::class, 'showAssignedDiagnosticos'])->name('users.diagnosticos');

Route::get('/formulario', function() {
    return view('Diagnosticos.formulario');
})->name('formulario'); // Asigna un nombre a la ruta
Route::post('/formulario', [FormularioController::class, 'index'])->name('formulario.index');

Route::get('/formulario2', function() {
    return view('Diagnosticos.formulario2');
})->name('formulario2'); // Asigna un nombre a la ruta
Route::post('/formulario2', [Formulario2Controller::class, 'index'])->name('formulario2.index');
//

Route::resource('diagnosticos', DiagnosticoController::class);

use App\Http\Controllers\FormController;

Route::get('encuestas/{estandar_id}', [FormController::class, 'showForm']);
Route::post('encuestas/{estandar_id}', [FormController::class, 'submitForm'])->name('form.submit');

Route::get('/admin/encuestas', [App\Http\Controllers\SurveyController::class, 'index'])->name('admin.surveys');
Route::get('/admin/encuestas/download', [App\Http\Controllers\SurveyController::class, 'download'])->name('admin.surveys.download');
Route::get('/admin/encuestas/{id}/download', [App\Http\Controllers\SurveyController::class, 'downloadIndividual'])->name('admin.surveys.downloadIndividual');

Route::get('/survey/download/{id}', [App\Http\Controllers\SurveyController::class, 'downloadIndividual'])->name('survey.download');


// routes/web.php
use App\Http\Controllers\SurveyController;

Route::get('/survey/download-file/{id}', [SurveyController::class, 'downloadIndividual'])->name('survey.downloadFile');


use App\Http\Controllers\AtencionUsuariosController;

Route::get('/formato-atencion/{estandar_id}', [AtencionUsuariosController::class, 'create'])->name('formato-atencion.create');
Route::post('/formato-atencion/{estandar_id}', [AtencionUsuariosController::class, 'store'])->name('formato-atencion.store');
Route::get('/formato-atencion/download/{estandar_id}', [AtencionUsuariosController::class, 'download'])->name('formato-atencion.download');
//
use App\Http\Controllers\AsignarDiagnosticosController;

Route::get('asignar-diagnosticos', [AsignarDiagnosticosController::class, 'index'])->name('usuarios.asignar-diagnosticos');
Route::post('asignar-diagnosticos', [AsignarDiagnosticosController::class, 'guardarAsignacion'])->name('usuarios.guardar-asignacion');

Route::get('/buscar-estandar/{id}', [AsignarDiagnosticosController::class, 'buscarEstandar']);

Route::get('/usuarios-con-diagnosticos', [AsignarDiagnosticosController::class, 'usuariosConDiagnosticos'])->name('usuarios.con-diagnosticos');