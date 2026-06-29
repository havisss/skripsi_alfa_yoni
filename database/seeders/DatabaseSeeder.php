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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin QC',
            'email' => 'qc@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin qc',
        ]);

        User::factory()->create([
            'name' => 'Admin Inventory',
            'email' => 'inventory@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin inventory',
        ]);

        User::factory()->create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);
    }
}
