<?php



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = ['admin', 'editor', 'viewer'];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        // Check if the permission already exists before creating it
        $permissionName = 'create users';
        $permission = Permission::where('name', $permissionName)->first();

        if (!$permission) {
            Permission::create(['name' => $permissionName]);
        }


    }
}
