<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
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
            ],
            [
                'nama_role' => 'Kepala Sekolah',
                'slug' => 'kepala-sekolah',
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['slug' => $role['slug']],
                ['nama_role' => $role['nama_role']]
            );
        }

        $permissions = [
            ['name' => 'Akses Dashboard', 'slug' => 'dashboard.view', 'group' => 'Umum'],
            ['name' => 'Kelola Role dan Hak Akses', 'slug' => 'roles.manage', 'group' => 'Administrasi'],
            ['name' => 'Kelola Pengguna', 'slug' => 'users.manage', 'group' => 'Administrasi'],
            ['name' => 'Kelola Unit Kerja', 'slug' => 'jurusans.manage', 'group' => 'Master Data'],
            ['name' => 'Lihat Monitor Ruang', 'slug' => 'monitor-ruang.view', 'group' => 'Master Data'],
            ['name' => 'Kelola Ruangan', 'slug' => 'ruangans.manage', 'group' => 'Master Data'],
            ['name' => 'Kelola Jenis Modal', 'slug' => 'jenis_modals.manage', 'group' => 'Master Data'],
            ['name' => 'Kelola Barang Inventaris', 'slug' => 'inventaris.manage', 'group' => 'Inventaris'],
            ['name' => 'Kelola Mutasi Barang', 'slug' => 'mutasis.manage', 'group' => 'Inventaris'],
            ['name' => 'Kelola Peminjaman', 'slug' => 'peminjamans.manage', 'group' => 'Inventaris'],
            ['name' => 'Kelola Usulan Pengadaan', 'slug' => 'pengadaans.manage', 'group' => 'Transaksi'],
            ['name' => 'Approval Pengadaan', 'slug' => 'approvals.manage', 'group' => 'Approval'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'],
                    'group' => $permission['group'],
                ]
            );
        }

        $permissionIds = Permission::pluck('id', 'slug');
        $defaultPermissions = [
            'super-admin' => $permissionIds->keys()->all(),
            'admin-sarpras' => [
                'dashboard.view',
                'users.manage',
                'jurusans.manage',
                'monitor-ruang.view',
                'ruangans.manage',
                'jenis_modals.manage',
                'inventaris.manage',
                'mutasis.manage',
                'peminjamans.manage',
                'pengadaans.manage',
            ],
            'petugas' => [
                'dashboard.view',
                'inventaris.manage',
                'monitor-ruang.view',
                'mutasis.manage',
                'peminjamans.manage',
                'pengadaans.manage',
            ],
            'peminjam' => [
                'dashboard.view',
                'peminjamans.manage',
                'pengadaans.manage',
            ],
            'kepala-sekolah' => [
                'dashboard.view',
                'inventaris.manage',
                'monitor-ruang.view',
                'pengadaans.manage',
                'approvals.manage',
            ],
        ];

        foreach ($defaultPermissions as $roleSlug => $permissionSlugs) {
            $role = Role::where('slug', $roleSlug)->first();

            if ($role) {
                $role->permissions()->syncWithoutDetaching(
                    collect($permissionSlugs)
                        ->map(fn (string $slug) => $permissionIds[$slug] ?? null)
                        ->filter()
                        ->values()
                        ->all()
                );
            }
        }
    }
}
