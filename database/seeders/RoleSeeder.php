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
        Role::firstOrCreate(
            ['name' => 'Admin'],
            ['description' => 'Administrator role dengan akses penuh']
        );

        Role::firstOrCreate(
            ['name' => 'Petugas'],
            ['description' => 'Staff role with restricted administrative access']
        );

        Role::firstOrCreate(
            ['name' => 'User'],
            ['description' => 'Regular customer role']
        );
    }
}
