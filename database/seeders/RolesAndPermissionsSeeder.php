<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Buat permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'create posts']);

        // Buat roles dan berikan permissions
        $superAdmin = Role::create(['name' => 'super_admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['view dashboard', 'edit users']);

        Role::create(['name' => 'user']);
        Role::create(['name' => 'viewer']);
    }
}
