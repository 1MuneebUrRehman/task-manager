<?php

namespace Database\Seeders;

use App\Enums\PermissionsEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create([
            'name' => RolesEnum::ADMIN,
        ]);

        $managerRole = Role::create([
            'name' => RolesEnum::MANAGER,
        ]);

        $userRole = Role::create([
            'name' => RolesEnum::USER,
        ]);

        Permission::create([
            'name' => PermissionsEnum::VIEW_TASKS,
        ]);

        Permission::create([
            'name' => PermissionsEnum::EDIT_TASKS,
        ]);

        Permission::create([
            'name' => PermissionsEnum::CREATE_TASKS,
        ]);

        Permission::create([
            'name' => PermissionsEnum::DELETE_TASKS,
        ]);

        $adminPermissions = [
            PermissionsEnum::CREATE_TASKS,
            PermissionsEnum::VIEW_TASKS,
            PermissionsEnum::EDIT_TASKS,
            PermissionsEnum::DELETE_TASKS,
        ];

        // Assign permissions to roles
        $adminRole->givePermissionTo($adminPermissions);

        $managerRole->givePermissionTo([
            PermissionsEnum::VIEW_TASKS,
            PermissionsEnum::EDIT_TASKS,
        ]);

        $userRole->givePermissionTo([
            PermissionsEnum::VIEW_TASKS,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Muneeb',
            'email' => '1muneeburrehman@gmail.com',
            'password' => Hash::make('1muneeburrehman@gmail.com'),
            'email_verified_at' => now(),
        ])->assignRole($adminRole)->givePermissionTo($adminPermissions);
    }
}
