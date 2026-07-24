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
        $this->call(UserSeeder::class);

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

        // Seed Jenis Modals
        $elektronik = \App\Models\JenisModal::firstOrCreate(
            ['nama_jenis_modal' => 'Modal Peralatan dan Mesin'],
            ['kode_jenis_modal' => 'MPM-001']
        );
        $mebel = \App\Models\JenisModal::firstOrCreate(
            ['nama_jenis_modal' => 'Mebel & Furniture'],
            ['kode_jenis_modal' => 'MBL-002']
        );

        // Seed Inventaris
        \App\Models\Inventaris::updateOrCreate(
            ['kode_inventaris' => 'INV-PC-RPL-001'],
            [
                'nama_barang' => 'Laptop Asus ExpertBook',
                'merek' => 'Asus',
                'type' => 'ExpertBook B1400',
                'spesifikasi' => 'Intel Core i5, RAM 8GB, SSD 512GB, Windows 11',
                'jenis_modal_id' => $elektronik->id,
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
                'type' => 'Standard Meja Praktikum',
                'spesifikasi' => 'Meja kayu lapis besi ukuran 120x60cm',
                'jenis_modal_id' => $mebel->id,
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
                'type' => 'CCR1009-7G-1C-1S+',
                'spesifikasi' => '9 Core CPU, 2GB RAM, 8x Gigabit Ethernet, 1x SFP Port',
                'jenis_modal_id' => $elektronik->id,
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
                'type' => 'WS-C2960+24TC-L',
                'spesifikasi' => '24 Port 10/100/1000 + 2 T/SFP',
                'jenis_modal_id' => $elektronik->id,
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
                    'user_id' => User::where('email', 'petugassarpras@example.com')->first()?->id,
                ]
            );
        }

        // Seeding Pengadaan (Usulan Pengadaan) untuk testing alur approval 2 tahap
        $pengusulUser = User::where('email', 'petugassarpras@example.com')->first();
        $adminUser = User::where('email', 'adminutama@example.com')->first();
        $kepsekUser = User::where('email', 'kepalasekolah@example.com')->first();

        $pengadaans = [
            [
                'nama_barang_usulan' => 'Proyektor Epson EB-X500',
                'jenis_modal_id' => $elektronik->id,
                'jurusan_id' => $rpl->id,
                'jumlah' => 3,
                'perkiraan_harga' => 7500000,
                'alasan_pengadaan' => 'Untuk kebutuhan presentasi dan mengajar di ruang kelas teori RPL.',
                'status_usulan' => 'pending',
                'user_id' => $pengusulUser?->id ?? $adminUser?->id,
            ],
            [
                'nama_barang_usulan' => 'Air Conditioner (AC) Daikin 1.5 PK',
                'jenis_modal_id' => $elektronik->id,
                'jurusan_id' => $tkj->id,
                'jumlah' => 2,
                'perkiraan_harga' => 6000000,
                'alasan_pengadaan' => 'AC di Lab TKJ 1 sudah sering rusak dan kurang dingin untuk mendinginkan server.',
                'status_usulan' => 'disetujui_admin',
                'user_id' => $pengusulUser?->id ?? $adminUser?->id,
                'approved_by_admin' => $adminUser?->id,
                'approved_by_admin_at' => now()->subDay(),
            ],
            [
                'nama_barang_usulan' => 'Meja Kursi Guru Set',
                'jenis_modal_id' => $mebel->id,
                'jurusan_id' => $rpl->id,
                'jumlah' => 5,
                'perkiraan_harga' => 1500000,
                'alasan_pengadaan' => 'Penggantian meja kursi guru yang sudah rapuh dimakan rayap.',
                'status_usulan' => 'disetujui_kepsek',
                'user_id' => $pengusulUser?->id ?? $adminUser?->id,
                'approved_by_admin' => $adminUser?->id,
                'approved_by_admin_at' => now()->subDays(3),
                'approved_by_kepsek' => $kepsekUser?->id,
                'approved_by_kepsek_at' => now()->subDays(2),
                'catatan_kepsek' => 'Disetujui, silakan koordinasikan dengan bendahara sarpras untuk realisasi pembelian.',
            ],
            [
                'nama_barang_usulan' => 'Printer HP Laserjet Pro M404dn',
                'jenis_modal_id' => $elektronik->id,
                'jurusan_id' => $rpl->id,
                'jumlah' => 1,
                'perkiraan_harga' => 4800000,
                'alasan_pengadaan' => 'Printer untuk mencetak administrasi ujian produktif RPL.',
                'status_usulan' => 'ditolak',
                'user_id' => $pengusulUser?->id ?? $adminUser?->id,
                'approved_by_admin' => $adminUser?->id,
                'approved_by_admin_at' => now()->subDays(4),
            ],
            [
                'nama_barang_usulan' => 'Kursi Lipat Chitose',
                'jenis_modal_id' => $mebel->id,
                'jurusan_id' => $tkj->id,
                'jumlah' => 30,
                'perkiraan_harga' => 350000,
                'alasan_pengadaan' => 'Untuk tambahan tempat duduk rapat jurusan TKJ.',
                'status_usulan' => 'ditolak_kepsek',
                'user_id' => $pengusulUser?->id ?? $adminUser?->id,
                'approved_by_admin' => $adminUser?->id,
                'approved_by_admin_at' => now()->subDays(5),
                'approved_by_kepsek' => $kepsekUser?->id,
                'approved_by_kepsek_at' => now()->subDays(4),
                'catatan_kepsek' => 'Ditolak sementara karena anggaran sarpras semester ini sudah terpakai sepenuhnya.',
            ],
        ];

        foreach ($pengadaans as $pengadaanData) {
            \App\Models\Pengadaan::firstOrCreate(
                ['nama_barang_usulan' => $pengadaanData['nama_barang_usulan']],
                $pengadaanData
            );
        }
    }
}
