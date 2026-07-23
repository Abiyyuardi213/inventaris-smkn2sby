<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Jurusan;
use App\Models\Ruangan;
use App\Models\Inventaris;
use App\Models\Peminjaman;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanNotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_overdue_borrowings_status_auto_updates_and_shows_alerts(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $kategori = Kategori::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        // Create an inventory item
        $item = Inventaris::create([
            'kode_inventaris' => 'INV-TEST-ALERT',
            'nama_barang' => 'Test Laptop',
            'merek' => 'HP',
            'spesifikasi' => 'Core i5',
            'kategori_id' => $kategori->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 10,
            'harga_satuan' => 10000000,
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-20',
        ]);

        // Create an overdue borrowing (estimated return date was yesterday)
        $overduePeminjaman = Peminjaman::create([
            'nama_peminjam' => 'Budi',
            'instansi' => 'SMKN 2',
            'kontak' => '0812',
            'inventaris_id' => $item->id,
            'jumlah_pinjam' => 2,
            'tanggal_pinjam' => now()->subDays(5)->toDateString(),
            'tanggal_estimasi_kembali' => now()->subDay()->toDateString(),
            'status' => 'Dipinjam',
            'user_id' => $user->id,
        ]);

        // Create an approaching borrowing (estimated return date is tomorrow)
        $approachingPeminjaman = Peminjaman::create([
            'nama_peminjam' => 'Andi',
            'instansi' => 'SMKN 2',
            'kontak' => '0813',
            'inventaris_id' => $item->id,
            'jumlah_pinjam' => 1,
            'tanggal_pinjam' => now()->subDays(2)->toDateString(),
            'tanggal_estimasi_kembali' => now()->addDay()->toDateString(),
            'status' => 'Dipinjam',
            'user_id' => $user->id,
        ]);

        // Access dashboard to trigger auto-update status check
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);

        // Verify that Budi's status was auto-updated to 'Terlambat'
        $this->assertDatabaseHas('peminjamans', [
            'id' => $overduePeminjaman->id,
            'status' => 'Terlambat',
        ]);

        // Verify that Andi's status remains 'Dipinjam'
        $this->assertDatabaseHas('peminjamans', [
            'id' => $approachingPeminjaman->id,
            'status' => 'Dipinjam',
        ]);

        // Go to peminjamans index and verify that alerts are shown
        $response = $this->actingAs($user)->get(route('peminjamans.index'));
        $response->assertSee('Keterlambatan Pengembalian');
        $response->assertSee('Jatuh Tempo Menjelang Kembali');
    }

    public function test_can_return_borrowed_item_and_restores_stock(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'adminutama@example.com')->first();
        $kategori = Kategori::first();
        $jurusan = Jurusan::first();
        $ruangan = Ruangan::where('jurusan_id', $jurusan->id)->first();

        // Create an inventory item with 10 units
        $item = Inventaris::create([
            'kode_inventaris' => 'INV-TEST-RETURN',
            'nama_barang' => 'Test Projector',
            'merek' => 'Epson',
            'spesifikasi' => '3000 lumens',
            'kategori_id' => $kategori->id,
            'jurusan_id' => $jurusan->id,
            'ruangan_id' => $ruangan->id,
            'jumlah_total' => 10,
            'harga_satuan' => 5000000,
            'kondisi' => 'baik',
            'tanggal_pengadaan' => '2026-07-20',
        ]);

        // Borrow 3 units (remaining stock will be 7)
        // Note: PeminjamanController@store does decrement stock, but we will create the peminjaman record directly
        // and decrement the stock to mock it correctly.
        $item->decrement('jumlah_total', 3);

        $peminjaman = Peminjaman::create([
            'nama_peminjam' => 'Candra',
            'instansi' => 'ITATS',
            'kontak' => '0814',
            'inventaris_id' => $item->id,
            'jumlah_pinjam' => 3,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_estimasi_kembali' => now()->addDays(5)->toDateString(),
            'status' => 'Dipinjam',
            'user_id' => $user->id,
        ]);

        // Assert starting stock is 7
        $this->assertEquals(7, $item->fresh()->jumlah_total);

        // Submit return request
        $response = $this->actingAs($user)
            ->post(route('peminjamans.kembalikan', $peminjaman->id));

        // Assert redirect to show details page
        $response->assertRedirect(route('peminjamans.show', $peminjaman->id));

        // Verify status updated to 'Dikembalikan'
        $this->assertDatabaseHas('peminjamans', [
            'id' => $peminjaman->id,
            'status' => 'Dikembalikan',
        ]);

        // Verify stock is restored to 10
        $this->assertEquals(10, $item->fresh()->jumlah_total);
    }
}
