<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nama_role' => 'Super Admin',
                'slug' => 'super-admin',
            ],
            [
                'nama_role' => 'Admin Sarpras',
                'slug' => 'admin-sarpras',
            ],
            [
                'nama_role' => 'Petugas',
                'slug' => 'petugas',
            ],
            [
                'nama_role' => 'Peminjam',
                'slug' => 'peminjam',
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                ['nama_role' => $role['nama_role']]
            );
        }
    }
}
