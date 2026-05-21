<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $superAdminRole = \App\Models\Role::where('slug', 'super-admin')->first();

        User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => $superAdminRole?->id,
        ]);
    }
}
