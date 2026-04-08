<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'Administrator role dengan akses penuh',
        ]);

        Role::create([
            'name' => 'User',
            'description' => 'Regular user role',
        ]);
    }
}
