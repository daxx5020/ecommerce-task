<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => true,
            ]
        );

        $role = Role::where('name', 'super-admin')->first();

        if (! $admin->roles()->where('name', 'super-admin')->exists()) {
            $admin->roles()->attach($role);
        }
    }
}
