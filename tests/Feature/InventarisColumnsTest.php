<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JenisModal;
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
        $jenisModal = JenisModal::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        $payload = [
            'kode_inventaris' => 'INV-TEST-999',
            'nama_barang' => 'Kursi Ergonomis Premium',
            'merek' => 'Steelcase',
            'type' => 'Leap V2',
            'spesifikasi' => 'Gas lift class 4, armrest 4D',
            'bahan' => 'Mesh dan Aluminium',
            'warna' => 'Abu-abu',
            'jenis_modal_id' => $jenisModal->id,
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
            'type' => 'Leap V2',
            'bahan' => 'Mesh dan Aluminium',
            'warna' => 'Abu-abu',
            'nama_penyedia' => 'PT Ergo Jaya',
            'nomor_surat_bast' => 'BAST-ERG-2026',
        ]);

        // Verify detail page shows values
        $item = Inventaris::where('kode_inventaris', 'INV-TEST-999')->first();
        $response = $this->actingAs($user)
            ->get(route('inventaris.show', $item->id));

        $response->assertSee('Leap V2');
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
            'type' => 'New Type V2',
            'spesifikasi' => $item->spesifikasi,
            'bahan' => 'Kayu Jati Grade A',
            'warna' => 'Coklat Tua',
            'jenis_modal_id' => $item->jenis_modal_id,
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
            'type' => 'New Type V2',
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
            'type' => 'Scanner Type 1',
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
                'type' => 'Scanner Type 1',
                'bahan' => 'Baja Ringan',
                'warna' => 'Hitam Pekat',
                'nama_penyedia' => 'PT Baja Bersama',
                'nomor_surat_bast' => 'BAST-BAJA-123',
            ],
        ]);
    }

    public function test_can_delete_selected_inventaris_in_bulk(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $jenisModal = JenisModal::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        // Create 2 fresh inventaris items that are not referenced by anything
        $item1 = Inventaris::create([
            'kode_inventaris' => 'INV-TEST-DEL-1',
            'nama_barang' => 'Test Del 1',
            'merek' => 'Test',
            'spesifikasi' => 'Test Spesifikasi',
            'jenis_modal_id' => $jenisModal->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 1,
            'harga_satuan' => 1000,
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-10',
        ]);

        $item2 = Inventaris::create([
            'kode_inventaris' => 'INV-TEST-DEL-2',
            'nama_barang' => 'Test Del 2',
            'merek' => 'Test',
            'spesifikasi' => 'Test Spesifikasi',
            'jenis_modal_id' => $jenisModal->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 1,
            'harga_satuan' => 1000,
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-10',
        ]);

        $ids = [$item1->id, $item2->id];

        $response = $this->actingAs($user)
            ->delete(route('inventaris.destroy-bulk'), ['ids' => implode(',', $ids)]);

        $response->assertRedirect(route('inventaris.index'));
        $this->assertDatabaseMissing('inventaris', ['id' => $item1->id]);
        $this->assertDatabaseMissing('inventaris', ['id' => $item2->id]);
    }

    public function test_can_delete_all_inventaris(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();

        // Delete dependencies first to avoid foreign key restrict errors
        \App\Models\Peminjaman::query()->delete();
        \App\Models\Mutasi::query()->delete();

        // Ensure there are items
        $this->assertGreaterThan(0, Inventaris::count());

        $response = $this->actingAs($user)
            ->delete(route('inventaris.destroy-all'));

        $response->assertRedirect(route('inventaris.index'));
        $this->assertEquals(0, Inventaris::count());
    }
}
