<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $pemilikRole = Role::create(['name' => 'pemilik']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_kos']);
        Permission::create(['name' => 'view_kos']);
        Permission::create(['name' => 'book_kos']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['manage_users', 'manage_kos']);
        $pemilikRole->givePermissionTo(['manage_kos']);
        $userRole->givePermissionTo(['view_kos', 'book_kos']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com.com',
            'password' => bcrypt('admin123'),
            'status' => 'active'
        ]);
        
        $admin->assignRole('admin');
    }
}
