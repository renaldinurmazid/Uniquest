<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignUserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil Role-nya
        $superAdminRole = Role::where('name', 'superadmin')->first();
        $adminRole      = Role::where('name', 'admin')->first();
        $studentRole    = Role::where('name', 'student')->first(); // Ambil role student

        // 2. Set user "super admin" jadi Superadmin
        $superAdminUser = User::where('name', 'like', '%Super Admin%')->first();
        if ($superAdminUser) {
            $superAdminUser->syncRoles([$superAdminRole->name]);
            $this->command->info("User {$superAdminUser->name} sekarang adalah Superadmin.");
        }

        // 3. Set user "admin" jadi Admin
        $adminUser = User::where('name', 'Admin')->first();
        if ($adminUser) {
            $adminUser->syncRoles([$adminRole->name]);
            $this->command->info("User {$adminUser->name} sekarang adalah Admin.");
        }

        // 4. Set user "luthfi ganteng" jadi Student
        $luthfiUser = User::where('name', 'like', '%Luthfi%')->first();
        if ($luthfiUser) {
            // Kita pakai syncRoles biar role 'superadmin' yang tadi nggak sengaja masuk langsung kehapus
            $luthfiUser->syncRoles([$studentRole->name]);
            $this->command->info("User {$luthfiUser->name} sekarang adalah STUDENT.");
        }
    }
}
