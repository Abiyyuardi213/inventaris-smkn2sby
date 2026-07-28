<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kategori;
use App\Models\JenisModal;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\Inventaris;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_manage_kategoris(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();

        // 1. Index
        $response = $this->actingAs($user)->get(route('kategoris.index'));
        $response->assertStatus(200);
        $response->assertSee('Komputer dan Laptop');

        // 2. Create / Store
        $payload = [
            'nama_kategori' => 'Alat Pengukur Presisi',
        ];
        $response = $this->actingAs($user)->post(route('kategoris.store'), $payload);
        $response->assertRedirect(route('kategoris.index'));

        $this->assertDatabaseHas('kategoris', [
            'nama_kategori' => 'Alat Pengukur Presisi',
        ]);

        $kategori = Kategori::where('nama_kategori', 'Alat Pengukur Presisi')->first();
        $this->assertNotNull($kategori->kode_kategori);
        $this->assertStringStartsWith('KAT-', $kategori->kode_kategori);

        // 3. Show
        $response = $this->actingAs($user)->get(route('kategoris.show', $kategori->id));
        $response->assertStatus(200);
        $response->assertSee('Alat Pengukur Presisi');

        // 4. Update
        $response = $this->actingAs($user)->put(route('kategoris.update', $kategori->id), [
            'nama_kategori' => 'Alat Ukur Kalibrasi',
        ]);
        $response->assertRedirect(route('kategoris.index'));
        $this->assertDatabaseHas('kategoris', [
            'id' => $kategori->id,
            'nama_kategori' => 'Alat Ukur Kalibrasi',
        ]);

        // 5. Delete
        $response = $this->actingAs($user)->delete(route('kategoris.destroy', $kategori->id));
        $response->assertRedirect(route('kategoris.index'));
        $this->assertDatabaseMissing('kategoris', [
            'id' => $kategori->id,
        ]);
    }

    public function test_inventaris_with_kategori(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $jenisModal = JenisModal::first();
        $kategori = Kategori::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        $payload = [
            'kode_inventaris' => 'INV-KAT-001',
            'nama_barang' => 'Oscilloscope Digital',
            'merek' => 'Rigol',
            'spesifikasi' => '100MHz 2 Channel',
            'jenis_modal_id' => $jenisModal->id,
            'kategori_id' => $kategori->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 2,
            'harga_satuan' => 4500000,
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-15',
        ];

        $response = $this->actingAs($user)->post(route('inventaris.store'), $payload);
        $response->assertRedirect(route('inventaris.index'));

        $this->assertDatabaseHas('inventaris', [
            'kode_inventaris' => 'INV-KAT-001',
            'kategori_id' => $kategori->id,
        ]);

        $item = Inventaris::where('kode_inventaris', 'INV-KAT-001')->first();

        $response = $this->actingAs($user)->get(route('inventaris.show', $item->id));
        $response->assertSee($kategori->nama_kategori);
    }
}
