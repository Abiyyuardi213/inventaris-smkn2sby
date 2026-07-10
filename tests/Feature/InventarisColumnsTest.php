<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\Inventaris;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventarisColumnsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_inventaris_with_bast_and_materials(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $kategori = Kategori::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        $payload = [
            'kode_inventaris' => 'INV-TEST-999',
            'nama_barang' => 'Kursi Ergonomis Premium',
            'merek' => 'Steelcase',
            'spesifikasi' => 'Gas lift class 4, armrest 4D',
            'bahan' => 'Mesh dan Aluminium',
            'warna' => 'Abu-abu',
            'kategori_id' => $kategori->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 10,
            'harga_satuan' => 5000000,
            'sumber_dana' => 'BOS Kinerja',
            'nama_penyedia' => 'PT Ergo Jaya',
            'nomor_surat_bast' => 'BAST-ERG-2026',
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-10',
            'foto_url' => 'https://drive.google.com/file/d/test/view',
        ];

        $response = $this->actingAs($user)
            ->post(route('inventaris.store'), $payload);

        $response->assertRedirect(route('inventaris.index'));

        // Verify stored in database
        $this->assertDatabaseHas('inventaris', [
            'kode_inventaris' => 'INV-TEST-999',
            'bahan' => 'Mesh dan Aluminium',
            'warna' => 'Abu-abu',
            'nama_penyedia' => 'PT Ergo Jaya',
            'nomor_surat_bast' => 'BAST-ERG-2026',
        ]);

        // Verify detail page shows values
        $item = Inventaris::where('kode_inventaris', 'INV-TEST-999')->first();
        $response = $this->actingAs($user)
            ->get(route('inventaris.show', $item->id));

        $response->assertSee('Mesh dan Aluminium');
        $response->assertSee('Abu-abu');
        $response->assertSee('PT Ergo Jaya');
        $response->assertSee('BAST-ERG-2026');
    }

    public function test_can_update_inventaris_with_bast_and_materials(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $item = Inventaris::first();

        $payload = [
            'kode_inventaris' => $item->kode_inventaris,
            'nama_barang' => $item->nama_barang,
            'merek' => $item->merek,
            'spesifikasi' => $item->spesifikasi,
            'bahan' => 'Kayu Jati Grade A',
            'warna' => 'Coklat Tua',
            'kategori_id' => $item->kategori_id,
            'jurusan_id' => $item->jurusan_id,
            'ruangan_id' => $item->ruangan_id,
            'jumlah_total' => $item->jumlah_total,
            'harga_satuan' => $item->harga_satuan,
            'sumber_dana' => $item->sumber_dana,
            'nama_penyedia' => 'CV Jati Agung',
            'nomor_surat_bast' => 'BAST-JATI-11',
            'kondisi' => $item->kondisi,
            'tanggal_pengadaan' => $item->tanggal_pengadaan->toDateString(),
            'foto_url' => $item->foto_url,
        ];

        $response = $this->actingAs($user)
            ->put(route('inventaris.update', $item->id), $payload);

        $response->assertRedirect(route('inventaris.index'));

        // Verify updated in database
        $this->assertDatabaseHas('inventaris', [
            'id' => $item->id,
            'bahan' => 'Kayu Jati Grade A',
            'warna' => 'Coklat Tua',
            'nama_penyedia' => 'CV Jati Agung',
            'nomor_surat_bast' => 'BAST-JATI-11',
        ]);
    }

    public function test_scanner_resolves_all_attributes(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $item = Inventaris::first();
        $item->update([
            'bahan' => 'Baja Ringan',
            'warna' => 'Hitam Pekat',
            'nama_penyedia' => 'PT Baja Bersama',
            'nomor_surat_bast' => 'BAST-BAJA-123',
        ]);

        $response = $this->actingAs($user)
            ->get(route('inventaris.scan.resolve', ['value' => $item->kode_inventaris]));

        $response->assertStatus(200);
        $response->assertJson([
            'found' => true,
            'item' => [
                'kode_inventaris' => $item->kode_inventaris,
                'nama_barang' => $item->nama_barang,
                'bahan' => 'Baja Ringan',
                'warna' => 'Hitam Pekat',
                'nama_penyedia' => 'PT Baja Bersama',
                'nomor_surat_bast' => 'BAST-BAJA-123',
            ],
        ]);
    }
}
