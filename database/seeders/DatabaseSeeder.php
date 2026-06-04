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
        $kepalaSekolahRole = \App\Models\Role::where('slug', 'kepala-sekolah')->first();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'nama' => 'Test User',
                'username' => 'testuser',
                'password' => bcrypt('password'),
                'role_id' => $superAdminRole?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'nama' => 'admin sarpras',
                'username' => 'admin',
                'password' => bcrypt('12345678'),
                'role_id' => $superAdminRole?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'kepalasekolah@example.com'],
            [
                'nama' => 'Kepala Sekolah',
                'username' => 'kepalasekolah',
                'password' => bcrypt('12345678'),
                'role_id' => $kepalaSekolahRole?->id,
            ]
        );

        // Seed Jurusans
        $rpl = \App\Models\Jurusan::firstOrCreate(
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak'],
            ['kode_jurusan' => 'RPL-001']
        );
        $tkj = \App\Models\Jurusan::firstOrCreate(
            ['nama_jurusan' => 'Teknik Komputer & Jaringan'],
            ['kode_jurusan' => 'TKJ-002']
        );

        // Seed Ruangans
        $labRpl = \App\Models\Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab RPL 1', 'jurusan_id' => $rpl->id]
        );
        $labTkj = \App\Models\Ruangan::firstOrCreate(
            ['nama_ruangan' => 'Lab TKJ 1', 'jurusan_id' => $tkj->id]
        );

        // Seed Kategoris
        $elektronik = \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Peralatan Elektronik'],
            ['kode_kategori' => 'ELK-001']
        );
        $mebel = \App\Models\Kategori::firstOrCreate(
            ['nama_kategori' => 'Mebel & Furniture'],
            ['kode_kategori' => 'MBL-002']
        );

        // Seed Inventaris
        \App\Models\Inventaris::updateOrCreate(
            ['kode_inventaris' => 'INV-PC-RPL-001'],
            [
                'nama_barang' => 'Laptop Asus ExpertBook',
                'merek' => 'Asus',
                'spesifikasi' => 'Intel Core i5, RAM 8GB, SSD 512GB, Windows 11',
                'kategori_id' => $elektronik->id,
                'jurusan_id' => $rpl->id,
                'ruangan_id' => $labRpl->id,
                'jumlah_total' => 20,
                'kondisi' => 'baik',
                'tanggal_pengadaan' => '2025-01-15'
            ]
        );

        \App\Models\Inventaris::updateOrCreate(
            ['kode_inventaris' => 'INV-MJ-RPL-002'],
            [
                'nama_barang' => 'Meja Komputer Praktikum',
                'merek' => 'Olympus',
                'spesifikasi' => 'Meja kayu lapis besi ukuran 120x60cm',
                'kategori_id' => $mebel->id,
                'jurusan_id' => $rpl->id,
                'ruangan_id' => $labRpl->id,
                'jumlah_total' => 20,
                'kondisi' => 'baik',
                'tanggal_pengadaan' => '2025-01-20'
            ]
        );

        \App\Models\Inventaris::updateOrCreate(
            ['kode_inventaris' => 'INV-RT-TKJ-001'],
            [
                'nama_barang' => 'RouterBoard Mikrotik CCR1009',
                'merek' => 'Mikrotik',
                'spesifikasi' => '9 Core CPU, 2GB RAM, 8x Gigabit Ethernet, 1x SFP Port',
                'kategori_id' => $elektronik->id,
                'jurusan_id' => $tkj->id,
                'ruangan_id' => $labTkj->id,
                'jumlah_total' => 5,
                'kondisi' => 'layak',
                'tanggal_pengadaan' => '2024-11-05'
            ]
        );

        \App\Models\Inventaris::updateOrCreate(
            ['kode_inventaris' => 'INV-SW-TKJ-002'],
            [
                'nama_barang' => 'Switch Cisco Catalyst 2960',
                'merek' => 'Cisco',
                'spesifikasi' => '24 Port 10/100/1000 + 2 T/SFP',
                'kategori_id' => $elektronik->id,
                'jurusan_id' => $tkj->id,
                'ruangan_id' => $labTkj->id,
                'jumlah_total' => 2,
                'kondisi' => 'rusak',
                'tanggal_pengadaan' => '2023-08-12'
            ]
        );

        // Sample peminjaman (external) if an inventaris exists
        $sampleInventaris = \App\Models\Inventaris::first();
        if ($sampleInventaris) {
            \App\Models\Peminjaman::updateOrCreate(
                [
                    'nama_peminjam' => 'Tamu Sekolah',
                    'inventaris_id' => $sampleInventaris->id,
                ],
                [
                    'instansi' => 'Komite Sekolah',
                    'kontak' => '08123456789',
                    'jumlah_pinjam' => 1,
                    'tanggal_pinjam' => now()->toDateString(),
                    'tanggal_estimasi_kembali' => now()->addDays(3)->toDateString(),
                    'status' => 'Dipinjam',
                    'user_id' => User::first()?->id,
                ]
            );
        }
    }
}
