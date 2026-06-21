<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::pluck('id', 'slug');

        $users = [
            [
                'nama' => 'Admin Utama',
                'username' => 'adminutama',
                'email' => 'adminutama@example.com',
                'password' => 'password',
                'role_slug' => 'super-admin',
            ],
            [
                'nama' => 'Admin Sarpras',
                'username' => 'adminsarpras',
                'email' => 'adminsarpras@example.com',
                'password' => 'password',
                'role_slug' => 'admin-sarpras',
            ],
            [
                'nama' => 'Petugas Sarpras',
                'username' => 'petugassarpras',
                'email' => 'petugassarpras@example.com',
                'password' => 'password',
                'role_slug' => 'petugas',
            ],
            [
                'nama' => 'Kepala Sekolah',
                'username' => 'kepalasekolah',
                'email' => 'kepalasekolah@example.com',
                'password' => 'password',
                'role_slug' => 'kepala-sekolah',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'nama' => $user['nama'],
                    'username' => $user['username'],
                    'password' => Hash::make($user['password']),
                    'role_id' => $roles[$user['role_slug']] ?? null,
                ]
            );
        }
    }
}
