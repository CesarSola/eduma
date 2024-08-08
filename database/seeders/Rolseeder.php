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
                $role1 = Role::firstOrCreate(['name' => 'Admin']);
                $role2 = Role::firstOrCreate(['name' => 'User']); // Asegúrate de crear el rol 'User'
                $role3 = Role::firstOrCreate(['name' => 'Evaluador']);

                // Crear o verificar si el permiso ya existe antes de crearlo
                $dashboardPermission = Permission::firstOrCreate(
                        ['name' => 'dashboard', 'guard_name' => 'web'],
                        ['description' => 'Ver el Dashboard']
                );

                // Asignar el permiso a los roles
                $dashboardPermission->syncRoles([$role1, $role3]);

                // Crear o verificar si los permisos ya existen antes de crearlos
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
                        ['name' => 'permissions.index', 'description' => 'Ver listado de Permisos'],
                        ['name' => 'permissions.show', 'description' => 'Ver Vista de Permisos'],
                        ['name' => 'permissions.create', 'description' => 'Crear un Permiso'],
                        ['name' => 'permissions.edit', 'description' => 'Editar un Permiso'],
                        ['name' => 'permissions.destroy', 'description' => 'Eliminar un Permiso'],
                        ['name' => 'evaluadores.index', 'description' => 'Vista evaluadores'],
                ];

                foreach ($permissions as $permissionData) {
                        $permission = Permission::firstOrCreate(
                                ['name' => $permissionData['name'], 'guard_name' => 'web'],
                                ['description' => $permissionData['description']]
                        );

                        // Asignar el permiso al rol Admin
                        $permission->syncRoles([$role1]);
                }
        }
}
