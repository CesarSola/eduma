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
            ['name' => 'roles.index', 'description' => 'Ver listado de roles'],
            ['name' => 'roles.show', 'description' => 'Vista de roles'],
            ['name' => 'roles.create', 'description' => 'Crear un rol'],
            ['name' => 'roles.edit', 'description' => 'Editar un rol'],
            ['name' => 'roles.destroy', 'description' => 'Eliminar un rol'],
            ['name' => 'permissions.index', 'description' => 'Tabla de permisos'],
            ['name' => 'permissions.show', 'description' => 'Vista de permisos'],
            ['name' => 'permissions.create', 'description' => 'Crear un permiso'],
            ['name' => 'permissions.edit', 'description' => 'Editar un permiso'],
            ['name' => 'permissions.destroy', 'description' => 'Eliminar un permiso'],
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
