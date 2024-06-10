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
        $role2 = Role::firstOrCreate(['name' => 'User']);

        // Crear o verificar si el permiso ya existe antes de crearlo
        $dashboardPermission = Permission::firstOrCreate(
            ['name' => 'dashboard', 'guard_name' => 'web'],
            ['description' => 'Ver el Dashboard']
        );

        // Asignar el permiso a los roles
        $dashboardPermission->syncRoles([$role1, $role2]);

        // Crear o verificar si los permisos ya existen antes de crearlos
        $permissions = [
            ['name' => 'users.index', 'description' => 'Ver listado de Usuarios'],
            ['name' => 'users.edit', 'description' => 'Asignar Un Rol'],
            ['name' => 'users.update', 'description' => 'Actualizar Un Rol'],
            ['name' => 'roles.index', 'description' => 'Ver listado de invernaderos'],
            ['name' => 'roles.show', 'description' => 'Ver Vista de Invernaderos'],
            ['name' => 'roles.create', 'description' => 'Crear un invenadero'],
            ['name' => 'roles.edit', 'description' => 'Editar un invernadero'],
            ['name' => 'roles.destroy', 'description' => 'Eliminar un invernadero'],
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
