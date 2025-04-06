<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::create(['name' => 'admin']);
        $role_standard = Role::create(['name' => 'standard']);


        $permission_read = Permission::create(['name' => 'read users']);
        $permission_edit = Permission::create(['name' => 'edit users']);
        $permission_write = Permission::create(['name' => 'write users']);
        $permission_delete = Permission::create(['name' => 'delete users']);

        $permissions_admin = [$permission_read, $permission_edit, $permission_write, $permission_delete];

        $role_admin->syncPermissions($permissions_admin);
        $role_standard->givePermissionTo($permission_read);
    }
}
