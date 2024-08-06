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
        $role1 = Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'Evaluador', 'guard_name' => 'web']);
        $role3 = Role::create(['name' => 'User', 'guard_name' => 'web']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'codigos-postales'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'users.update'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'calendario.index']);

        Permission::create(['name' => 'competencias.agregar-fechas'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'competencias.guardar-fechas-modal'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'competencias.filtrarCompetencias'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'evaluadores.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evaluadores.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evaluadores.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evaluadores.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evaluadores.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evaluadores.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'registroGeneral.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'registroGeneral.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'registroGeneral.updateDocumento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'usuariosAdmin.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'usuariosAdmin.show'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'cursosExpediente.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursosExpediente.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'evidenciasACU.index'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'competencia.index'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'evidenciasACO.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'evidenciasACO.updateEvidencia'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'fichas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'ValidarFicha.updateDocumento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'cartas.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'ValidarCarta.updateDocumento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'documentosE.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'ValidarDocumento.updateDocumento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'validarCoP.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'validarCoP.updateComprobante'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'validarCuP.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'validarCuP.updateComprobante'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'usuarios.index'])->assignRole($role3);

        Permission::create(['name' => 'documentosUser.index'])->assignRole($role3);
        Permission::create(['name' => 'documentosUser.store'])->assignRole($role3);
        Permission::create(['name' => 'documentosUser.edit'])->assignRole($role3);
        Permission::create(['name' => 'documentosUser.update'])->assignRole($role3);

        Permission::create(['name' => 'competenciaEC.index'])->assignRole($role3);
        Permission::create(['name' => 'competenciaEC.show'])->assignRole($role3);
        Permission::create(['name' => 'competenciaEC.store'])->assignRole($role3);

        Permission::create(['name' => 'registroCurso.index'])->assignRole($role3);
        Permission::create(['name' => 'registroCurso.show'])->assignRole($role3);
        Permission::create(['name' => 'registroCurso.store'])->assignRole($role3);

        Permission::create(['name' => 'miscompetencias.index'])->assignRole($role3);
        Permission::create(['name' => 'miscompetencias.resubir_comprobante'])->assignRole($role3);
        Permission::create(['name' => 'miscompetencias.guardarResubirComprobante'])->assignRole($role3);

        Permission::create(['name' => 'misCursos.index'])->assignRole($role3);
        Permission::create(['name' => 'misCursos.resubir_comprobante'])->assignRole($role3);
        Permission::create(['name' => 'misCursos.guardarResubirComprobante'])->assignRole($role3);

        Permission::create(['name' => 'evidenciasEC.index'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasEC.show'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasEC.upload'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasEC.download'])->assignRole($role3);

        Permission::create(['name' => 'Plan.show'])->assignRole($role3);
        Permission::create(['name' => 'plan.store'])->assignRole($role3);

        Permission::create(['name' => 'evidencias.resubir'])->assignRole($role3);
        Permission::create(['name' => 'evidencias.resubir.submit'])->assignRole($role3);

        Permission::create(['name' => 'mis.evidencias'])->assignRole($role3);

        Permission::create(['name' => 'fechas.index'])->assignRole($role3);
        Permission::create(['name' => 'fechas.show'])->assignRole($role3);
        Permission::create(['name' => 'fechas.store'])->assignRole($role3);

        Permission::create(['name' => 'evidenciasCU.index'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasCU.show'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasCU.upload'])->assignRole($role3);
        Permission::create(['name' => 'evidenciasCU.download'])->assignRole($role3);

        Permission::create(['name' => 'cursos.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.destroy'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'cursos.storeDocumento'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'roles.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.destroy'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'permissions.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.create'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.show'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.store'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.edit'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.update'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'permissions.destroy'])->syncRoles([$role1, $role2]);
    }
}
