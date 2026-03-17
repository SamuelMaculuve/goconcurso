<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            // Users
            'view users', 'create users', 'edit users', 'delete users',
            // Companies
            'view companies', 'create companies', 'edit companies', 'delete companies', 'verify companies',
            // Contests
            'view contests', 'create contests', 'edit contests', 'delete contests',
            'approve contests', 'reject contests',
            // Plans
            'view plans', 'create plans', 'edit plans', 'delete plans',
            // Categories
            'view categories', 'create categories', 'edit categories', 'delete categories',
            // Applications
            'view applications', 'manage applications',
            // Interests
            'view interests',
            // Statistics
            'view statistics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->syncPermissions(Permission::all());

        $company = Role::firstOrCreate(['name' => 'company']);
        $company->syncPermissions([
            'create contests', 'edit contests', 'delete contests',
            'view applications', 'manage applications',
            'view interests',
            'view statistics',
        ]);

        $advertiser = Role::firstOrCreate(['name' => 'advertiser']);
        $advertiser->syncPermissions([
            'view statistics',
        ]);

        Role::firstOrCreate(['name' => 'candidate']);
    }
}
