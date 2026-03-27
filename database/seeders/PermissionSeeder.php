<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── 1. Seed Permissions ─────────────────────────────
        // Hanya simpan 'name' karena kita pakai Pure Spatie (Tanpa label/group)
        $permissions = [
            // Quest Management
            'quest.view',
            'quest.create',
            'quest.edit',
            'quest.delete',
            'quest.publish',
            'quest.qr',

            // Student Management
            'student.view',
            'student.create',
            'student.edit',
            'student.flag',
            'student.xp',

            // Point Shop & Economy
            'shop.view',
            'shop.manage',
            'shop.verify',
            'shop.restock',

            // System & Analytics
            'system.users',
            'system.roles',
            'analytics.view',
            'analytics.export',
            'system.settings',

            // Verification
            'verify.cert',
            'verify.redeem',
            'verify.fraud',
        ];

        foreach ($permissions as $permName) {
            Permission::firstOrCreate([
                'name' => $permName,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('✅ ' . count($permissions) . ' permissions seeded.');

        // ─── 2. Tambah roles yang belum ada ──────────────────
        $roles = [
            'superadmin',
            'admin',
            'staff',
            'sub-admin',
            'verifier',
            'student'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web'
            ]);
        }

        $this->command->info('✅ Roles checked/added.');

        // ─── 3. Assign permissions ke tiap role ──────────────
        $rolePerms = [
            'superadmin' => Permission::all(), // Superadmin dapet semua

            'admin'      => [
                'quest.view',
                'quest.create',
                'quest.edit',
                'quest.delete',
                'quest.publish',
                'quest.qr',
                'student.view',
                'student.create',
                'student.edit',
                'student.flag',
                'student.xp',
                'shop.view',
                'shop.manage',
                'shop.verify',
                'shop.restock',
                'analytics.view',
                'analytics.export',
                'verify.cert',
                'verify.redeem',
                'verify.fraud',
            ],

            'staff'      => [
                'quest.view',
                'quest.create',
                'quest.edit',
                'quest.publish',
                'quest.qr',
                'student.view',
                'shop.view',
                'shop.verify',
                'analytics.view',
                'verify.redeem',
            ],

            'sub-admin'  => [
                'quest.view',
                'quest.create',
                'quest.edit',
                'quest.publish',
                'quest.qr',
            ],

            'student'    => ['quest.view', 'shop.view'],

            'verifier'   => ['shop.verify', 'verify.cert', 'verify.redeem', 'verify.fraud'],
        ];

        foreach ($rolePerms as $roleName => $perms) {
            $role = Role::where('name', $roleName)->first();

            if ($role) {
                // Spatie syncPermissions bisa menerima array nama permission atau koleksi model
                $role->syncPermissions($perms);
                $this->command->info("  → [{$roleName}] permissions assigned.");
            }
        }

        $this->command->info('✅ All done! Database UniQuest is now ready.');
    }
}
