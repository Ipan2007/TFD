<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles first
        $this->call([RoleSeeder::class]);

        // User::factory(10)->create();

        // Create test user with User role
        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Attach User role to test user
        $testUser->roles()->attach(2); // ID 2 is User role

        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Attach Admin role to admin user
        $adminUser->roles()->attach(1); // ID 1 is Admin role

        $this->call([ProductSeeder::class]);
    }
}
