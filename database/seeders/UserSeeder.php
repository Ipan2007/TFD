<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create ADMIN Account
        $admin = User::firstOrCreate(
            ['email' => 'admin@tfd.com'],
            [
                'name' => 'Administrator TFD',
                'password' => Hash::make('password123'),
            ]
        );
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) $admin->roles()->sync([$adminRole->id]);

        // 2. Create PETUGAS Account
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@tfd.com'],
            [
                'name' => 'Petugas Toko TFD',
                'password' => Hash::make('password123'),
            ]
        );
        $petugasRole = Role::where('name', 'Petugas')->first();
        if ($petugasRole) $petugas->roles()->sync([$petugasRole->id]);

        // 3. Create REGULAR USER Account
        $user = User::firstOrCreate(
            ['email' => 'user@tfd.com'],
            [
                'name' => 'Regular Customer TFD',
                'password' => Hash::make('password123'),
            ]
        );
        $userRole = Role::where('name', 'User')->first();
        if ($userRole) $user->roles()->sync([$userRole->id]);
    }
}
