<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Rolseeder extends Seeder
{
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
                // Crear roles
                $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
                $roleUser = Role::firstOrCreate(['name' => 'User']);
                $roleEvaluator = Role::firstOrCreate(['name' => 'Evaluador']);

                // Crear permisos y asignarlos al rol Admin
                $permissions = [
                        ['name' => 'dashboard', 'description' => 'Ver el Dashboard'],
                        ['name' => 'users.index', 'description' => 'Ver listado de Usuarios'],
                        ['name' => 'users.edit', 'description' => 'Asignar Un Rol'],
                        ['name' => 'users.update', 'description' => 'Actualizar Un Rol'],
                        ['name' => 'roles.index', 'description' => 'Ver listado de Roles'],
                        ['name' => 'roles.show', 'description' => 'Ver Vista de Roles'],
                        ['name' => 'roles.create', 'description' => 'Crear un Rol'],
                        ['name' => 'roles.edit', 'description' => 'Editar un Rol'],
                        ['name' => 'roles.destroy', 'description' => 'Eliminar un Rol'],
                        ['name' => 'dashboard', 'description' => 'Ver el Dashboard'],
                        ['name' => 'codigos-postales', 'description' => 'Gestionar códigos postales'],
                        ['name' => 'users.index', 'description' => 'Ver listado de Usuarios'],
                        ['name' => 'users.edit', 'description' => 'Asignar un Rol'],
                        ['name' => 'users.update', 'description' => 'Actualizar un Rol'],
                        ['name' => 'calendario.index', 'description' => 'Ver el calendario'],
                        ['name' => 'competencias.agregar-fechas', 'description' => 'Agregar fechas a competencias'],
                        ['name' => 'competencias.guardar-fechas-modal', 'description' => 'Guardar fechas desde el modal de competencias'],
                        ['name' => 'competencias.filtrarCompetencias', 'description' => 'Filtrar competencias'],
                        ['name' => 'evaluadores.index', 'description' => 'Ver listado de Evaluadores'],
                        ['name' => 'evaluadores.store', 'description' => 'Crear un Evaluador'],
                        ['name' => 'evaluadores.show', 'description' => 'Ver detalles de un Evaluador'],
                        ['name' => 'evaluadores.edit', 'description' => 'Editar un Evaluador'],
                        ['name' => 'evaluadores.update', 'description' => 'Actualizar un Evaluador'],
                        ['name' => 'evaluadores.destroy', 'description' => 'Eliminar un Evaluador'],
                        ['name' => 'registroGeneral.index', 'description' => 'Ver registro general'],
                        ['name' => 'registroGeneral.show', 'description' => 'Ver detalles del registro general'],
                        ['name' => 'registroGeneral.updateDocumento', 'description' => 'Actualizar documento en el registro general'],
                        ['name' => 'usuariosAdmin.index', 'description' => 'Ver listado de Usuarios Administrativos'],
                        ['name' => 'usuariosAdmin.show', 'description' => 'Ver detalles de Usuario Administrativo'],
                        ['name' => 'usuariosAdmin.create', 'description' => 'Crear un Usuario Administrativo'],
                        ['name' => 'usuariosAdmin.update', 'description' => 'Actualizar un Usuario Administrativo'],
                        ['name' => 'usuariosAdmin.destroy', 'description' => 'Eliminar un Usuario Administrativo'],
                        ['name' => 'cursosExpediente.index', 'description' => 'Ver listado de Expedientes de Cursos'],
                        ['name' => 'cursosExpediente.create', 'description' => 'Crear un expediente de curso'],
                        ['name' => 'cursosExpediente.store', 'description' => 'Guardar un expediente de curso'],
                        ['name' => 'cursosExpediente.show', 'description' => 'Ver detalles del expediente de curso'],
                        ['name' => 'cursosExpediente.update', 'description' => 'Actualizar expediente de curso'],
                        ['name' => 'cursosExpediente.edit', 'description' => 'Editar expediente de curso'],
                        ['name' => 'cursosExpediente.destroy', 'description' => 'Eliminar expediente de curso'],
                        ['name' => 'evidenciasACU.index', 'description' => 'Ver listado de Evidencias ACU'],
                        ['name' => 'competencia.index', 'description' => 'Ver listado de Competencias'],
                        ['name' => 'competencias.create', 'description' => 'Crear una Competencia'],
                        ['name' => 'competencias.store', 'description' => 'Guardar una Competencia'],
                        ['name' => 'competencias.show', 'description' => 'Ver detalles de una Competencia'],
                        ['name' => 'competencias.update', 'description' => 'Actualizar una Competencia'],
                        ['name' => 'competencias.destroy', 'description' => 'Eliminar una Competencia'],
                        ['name' => 'evidenciasACO.index', 'description' => 'Ver listado de Evidencias ACO'],
                        ['name' => 'evidenciasACO.updateEvidencia', 'description' => 'Actualizar evidencia ACO'],
                        ['name' => 'documentos.index', 'description' => 'Ver listado de Documentos'],
                        ['name' => 'documentos.create', 'description' => 'Crear un Documento'],
                        ['name' => 'documentos.store', 'description' => 'Guardar un Documento'],
                        ['name' => 'documentos.show', 'description' => 'Ver detalles de un Documento'],
                        ['name' => 'documentos.update', 'description' => 'Actualizar un Documento'],
                        ['name' => 'documentos.destroy', 'description' => 'Eliminar un Documento'],
                        ['name' => 'fichas.show', 'description' => 'Ver ficha de registro'],
                        ['name' => 'ValidarFicha.updateDocumento', 'description' => 'Actualizar documento de ficha'],
                        ['name' => 'cartas.show', 'description' => 'Ver carta de autorización'],
                        ['name' => 'ValidarCarta.updateDocumento', 'description' => 'Actualizar documento de carta'],
                        ['name' => 'documentosE.show', 'description' => 'Ver documentos evidencias'],
                        ['name' => 'ValidarDocumento.updateDocumento', 'description' => 'Actualizar documento de evidencia'],
                        ['name' => 'validarCoP.show', 'description' => 'Ver validación de comprobantes de pagos'],
                        ['name' => 'validarCoP.updateComprobante', 'description' => 'Actualizar comprobante de pago'],
                        ['name' => 'validarCuP.show', 'description' => 'Ver validación de comprobantes de cursos'],
                        ['name' => 'validarCuP.updateComprobante', 'description' => 'Actualizar comprobante de curso'],
                        ['name' => 'usuarios.index', 'description' => 'Ver listado de Usuarios'],
                        ['name' => 'documentosUser.index', 'description' => 'Ver documentos del Usuario'],
                        ['name' => 'documentosUser.store', 'description' => 'Subir documento del Usuario'],
                        ['name' => 'documentosUser.edit', 'description' => 'Editar documento del Usuario'],
                        ['name' => 'documentosUser.update', 'description' => 'Actualizar documento del Usuario'],
                        ['name' => 'competenciaEC.index', 'description' => 'Ver listado de Competencias EC'],
                        ['name' => 'competenciaEC.show', 'description' => 'Ver detalles de Competencia EC'],
                        ['name' => 'competenciaEC.store', 'description' => 'Guardar Competencia EC'],
                        ['name' => 'registroCurso.index', 'description' => 'Ver listado de Registro de Cursos'],
                        ['name' => 'registroCurso.show', 'description' => 'Ver detalles del Registro de Curso'],
                        ['name' => 'registroCurso.store', 'description' => 'Guardar Registro de Curso'],
                        ['name' => 'miscompetencias.index', 'description' => 'Ver mis competencias'],
                        ['name' => 'miscompetencias.resubir_comprobante', 'description' => 'Subir comprobante de mis competencias'],
                        ['name' => 'miscompetencias.guardarResubirComprobante', 'description' => 'Guardar comprobante de mis competencias'],
                        ['name' => 'misCursos.index', 'description' => 'Ver mis cursos'],
                        ['name' => 'misCursos.resubir_comprobante', 'description' => 'Subir comprobante de mis cursos'],
                        ['name' => 'misCursos.guardarResubirComprobante', 'description' => 'Guardar comprobante de mis cursos'],
                        ['name' => 'evidenciasEC.index', 'description' => 'Ver listado de Evidencias EC'],
                        ['name' => 'evidenciasEC.show', 'description' => 'Ver detalles de Evidencia EC'],
                        ['name' => 'evidenciasEC.upload', 'description' => 'Subir Evidencia EC'],
                        ['name' => 'evidenciasEC.download', 'description' => 'Descargar Evidencia EC'],
                        ['name' => 'Plan.show', 'description' => 'Ver plan'],
                        ['name' => 'plan.store', 'description' => 'Guardar plan'],
                        ['name' => 'evidencias.resubir', 'description' => 'Subir evidencia nuevamente'],
                        ['name' => 'evidencias.resubir.submit', 'description' => 'Enviar evidencia nuevamente'],
                        ['name' => 'mis.evidencias', 'description' => 'Ver mis evidencias'],
                        ['name' => 'fechas.index', 'description' => 'Ver listado de fechas'],
                        ['name' => 'fechas.show', 'description' => 'Ver detalles de fecha'],
                        ['name' => 'fechas.store', 'description' => 'Guardar fecha'],
                        ['name' => 'fechas.update', 'description' => 'Actualizar una fecha'],
                        ['name' => 'fechas.destroy', 'description' => 'Eliminar una fecha'],
                        ['name' => 'evidenciasCU.index', 'description' => 'Ver listado de Evidencias CU'],
                        ['name' => 'evidenciasCU.show', 'description' => 'Ver detalles de Evidencia CU'],
                        ['name' => 'evidenciasCU.upload', 'description' => 'Subir Evidencia CU'],
                        ['name' => 'evidenciasCU.download', 'description' => 'Descargar Evidencia CU'],
                        ['name' => 'cursos.index', 'description' => 'Ver listado de Cursos'],
                        ['name' => 'cursos.create', 'description' => 'Crear un Curso'],
                        ['name' => 'cursos.show', 'description' => 'Ver detalles de un Curso'],
                        ['name' => 'cursos.update', 'description' => 'Actualizar un Curso'],
                        ['name' => 'cursos.destroy', 'description' => 'Eliminar un Curso'],
                        ['name' => 'eventos.create', 'description' => 'Crear un Evento'],
                        ['name' => 'eventos.update', 'description' => 'Actualizar un Evento'],
                        ['name' => 'eventos.destroy', 'description' => 'Eliminar un Evento'],

                ];

                foreach ($permissions as $permissionData) {
                        $permission = Permission::firstOrCreate(
                                ['name' => $permissionData['name'], 'guard_name' => 'web'],
                                ['description' => $permissionData['description']]
                        );

                        // Asignar el permiso al rol Admin
                        $permission->syncRoles([$roleAdmin]);
                }

                // Agregar permisos específicos para los roles User y Evaluador
                $userPermissions = [
                        'users.index',
                        'users.edit',
                        'users.update',
                        'roles.index',
                        'roles.show',
                        'roles.create',
                        'roles.edit',
                        'roles.destroy',
                        'permissions.index',
                        'permissions.show',
                        'permissions.create',
                        'permissions.edit',
                        'permissions.destroy'
                ];

                $evaluatorPermissions = [
                        'users.index',
                        'users.edit',
                        'users.update',
                        'roles.index',
                        'roles.show',
                        'roles.create',
                        'roles.edit',
                        'roles.destroy',
                        'permissions.index',
                        'permissions.show',
                        'permissions.create',
                        'permissions.edit',
                        'permissions.destroy'
                ];

                foreach ($userPermissions as $perm) {
                        $permission = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
                        $permission->syncRoles([$roleUser]);
                }

                foreach ($evaluatorPermissions as $perm) {
                        $permission = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
                        $permission->syncRoles([$roleEvaluator]);
                }
        }
}