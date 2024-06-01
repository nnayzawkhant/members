<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign 'admin' role to admin user
        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);

        // Create editor user
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign 'editor' role to editor user
        $editorRole = Role::where('name', 'editor')->first();
        $editor->assignRole($editorRole);

        // Create viewer user
        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign 'viewer' role to viewer user
        $viewerRole = Role::where('name', 'viewer')->first();
        $viewer->assignRole($viewerRole);
    }
}
