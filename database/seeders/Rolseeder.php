<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $role1 = Role::create(['name'=>'Admin']);
        $role2 = Role::create(['name'=>'User']);

        Permission::create(['name'=>'dashboard',
                            'description'=>'Ver el Dasboard'])->syncRoles([$role1,$role2]);

        
        Permission::create(['name'=>'users.index',
                            'description'=>'Ver listado  de Usuarios'])->assignRole([$role1]);
        Permission::create(['name'=>'users.edit',
                            'description'=>'Asignar Un Rol'])->assignRole([$role1]);
        Permission::create(['name'=>'users.update',
                            'description'=>'Actualizar Un Rol'])->assignRole([$role1]);

                            
        Permission::create(['name'=>'roles.index',
                            'description'=>'Ver listado de invernaderos'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.show',
                            'description'=>'Ver Vista de Invernaderos'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.create',
                            'description'=>'Crear un invenadero'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.edit',
                            'description'=>'Editar un invernadero'])->syncRoles([$role1]);
        Permission::create(['name'=>'roles.destroy',
                            'description'=>'Eliminar un invernadero'])->syncRoles([$role1]);
    }
}
