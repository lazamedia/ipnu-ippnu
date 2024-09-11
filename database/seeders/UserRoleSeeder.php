<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Buat Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $superAdmin->assignRole('super_admin');

        // Buat Admin
        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('admin');

        // Buat User
        $user = User::create([
            'name' => 'Regular User',
            'username' => 'regularuser',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);
        $user->assignRole('user');

        // Buat Viewer
        $viewer = User::create([
            'name' => 'Viewer User',
            'username' => 'vieweruser',
            'email' => 'viewer@example.com',
            'password' => Hash::make('password123'),
        ]);
        $viewer->assignRole('viewer');
    }
}
