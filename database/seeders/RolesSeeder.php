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
        $role_authority = Role::create(['name' => 'authority']);
        $role_public = Role::create(['name' => 'public']);


        $dasbhoard_read = Permission::create(['name' => 'read dashboard']);

        $user_read = Permission::create(['name' => 'read user']);
        $user_edit = Permission::create(['name' => 'edit user']);
        $user_write = Permission::create(['name' => 'write user']);
        $user_delete = Permission::create(['name' => 'delete user']);

        $role_read = Permission::create(['name' => 'read role']);
        $role_edit = Permission::create(['name' => 'edit role']);
        $role_write = Permission::create(['name' => 'write role']);
        $role_delete = Permission::create(['name' => 'delete role']);

        $permission_read = Permission::create(['name' => 'read permission']);
        $permission_edit = Permission::create(['name' => 'edit permission']);
        $permission_write = Permission::create(['name' => 'write permission']);
        $permission_delete = Permission::create(['name' => 'delete permission']);

        $sensor_read = Permission::create(['name' => 'read sensor']);
        $sensor_edit = Permission::create(['name' => 'edit sensor']);
        $sensor_write = Permission::create(['name' => 'write sensor']);
        $sensor_delete = Permission::create(['name' => 'delete sensor']);

        $alert_read = Permission::create(['name' => 'read alert']);
        $alert_edit = Permission::create(['name' => 'edit alert']);
        $alert_write = Permission::create(['name' => 'write alert']);
        $alert_delete = Permission::create(['name' => 'delete alert']);

        $permissions_admin = [
            $dasbhoard_read,
            $permission_read, 
            $permission_edit, 
            $permission_write, 
            $permission_delete,
            $user_read,
            $user_edit,
            $user_write,
            $user_delete,
            $role_read,
            $role_edit,
            $role_write,
            $role_delete,
            $sensor_read,
            $sensor_edit,
            $sensor_write,
            $sensor_delete,
            $alert_read,
            $alert_edit,
            $alert_write,
            $alert_delete,
        ];

        $permissions_authority = [
            $dasbhoard_read,
            $sensor_read,
            $sensor_edit,
            $sensor_write,
            $sensor_delete,
            $alert_read,
            $alert_edit,
            $alert_write,
            $alert_delete,
        ];

        $permission_public = [
            $dasbhoard_read,
        ];

        $role_admin->syncPermissions($permissions_admin);
        $role_authority->syncPermissions($permissions_authority);
        $role_public->syncPermissions($permission_public);
    }
}
