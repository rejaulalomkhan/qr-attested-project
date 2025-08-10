<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clean uploaded originals as part of seeding
        try {
            Storage::disk('public')->deleteDirectory('documents/original');
            Storage::disk('public')->makeDirectory('documents/original');
        } catch (\Throwable $e) {
            // ignore cleanup errors during seeding
        }

        // Seed default admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
    }
}
