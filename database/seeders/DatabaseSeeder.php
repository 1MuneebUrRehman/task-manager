<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RolesNameEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $role = Role::where('name', RolesNameEnum::Admin)->first();

        \App\Models\User::factory()->create([
            'name' => 'Muneeb',
            'email' => '1muneeburrehman@gmail.com',
            'password' => Hash::make('1muneeburrehman@gmail.com'),
            'email_verified_at' => now()
        ])->assignRole($role);
    }
}
