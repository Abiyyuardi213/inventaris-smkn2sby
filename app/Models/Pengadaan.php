<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'nama_barang_usulan',
    'kategori_id',
    'jurusan_id',
    'jumlah',
    'perkiraan_harga',
    'alasan_pengadaan',
    'status_usulan',
    'user_id',
])]
class Pengadaan extends Model
{
    use HasUuids;

    protected $table = 'pengadaans';

    /**
     * Cast kolom ke tipe PHP yang sesuai.
     * - perkiraan_harga: integer agar bisa diformat dengan number_format()
     * - jumlah: integer agar aritmatika tidak error karena string dari DB
     * - status_usulan: string (enum disimpan sebagai string di MySQL)
     */
    protected $casts = [
        'perkiraan_harga' => 'integer',
        'jumlah'          => 'integer',
        'status_usulan'   => 'string',
    ];

    protected static function booted(): void
    {
        /**
         * EVENT: deleting
         * Proteksi hapus — usulan hanya boleh dihapus selama masih berstatus 'pending'.
         * Jika sudah diproses (disetujui/ditolak), hapus diblokir karena data
         * sudah menjadi bagian dari alur persetujuan yang tidak boleh dihilangkan.
         */
        static::deleting(function (Pengadaan $pengadaan) {
            if (! $pengadaan->isPending()) {
                throw new \Exception(
                    "Usulan pengadaan tidak dapat dihapus karena sudah diproses (status: {$pengadaan->status_usulan})."
                );
            }
        });

        /**
         * EVENT: updating
         * Proteksi edit — setelah diproses (bukan pending), isi usulan tidak boleh diubah.
         * Pengecualian: perubahan pada kolom status_usulan itu sendiri TETAP DIIZINKAN
         * agar Super Admin bisa melakukan approve/tolak tanpa terblokir.
         *
         * Cara kerja:
         * - getOriginal('status_usulan') → status di DB sebelum perubahan
         * - getDirty() → array kolom yang sedang diubah pada request ini
         * - Jika satu-satunya kolom yang berubah adalah 'status_usulan', berarti
         *   ini adalah aksi approve/tolak → lewatkan validasi.
         * - Jika ada kolom lain yang ikut berubah dan status sudah diproses → blokir.
         */
        static::updating(function (Pengadaan $pengadaan) {
            $statusAsli = $pengadaan->getOriginal('status_usulan');

            // Hanya blokir jika status di DB sudah bukan 'pending'
            if ($statusAsli !== 'pending') {
                $kolomYangBerubah = array_keys($pengadaan->getDirty());

                // Izinkan jika satu-satunya kolom yang berubah adalah status_usulan
                // (aksi approve/tolak oleh Super Admin)
                $hanyaStatusBerubah = $kolomYangBerubah === ['status_usulan'];

                if (! $hanyaStatusBerubah) {
                    throw new \Exception(
                        'Usulan pengadaan tidak dapat diedit karena sudah diproses.'
                    );
                }
            }
        });
    }

    // =========================================================================
    // RELASI
    // =========================================================================

    /**
     * Relasi ke model Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Relasi ke model Jurusan.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi ke model User (pengusul usulan pengadaan).
     * Menggunakan nama method 'pengusul' — bukan 'user' — agar semantik lebih jelas.
     * foreignKey 'user_id' didefinisikan eksplisit karena nama method tidak mengikuti konvensi.
     */
    public function pengusul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================================================================
    // HELPER METHODS — STATUS CHECK
    // =========================================================================

    /**
     * Cek apakah usulan masih dalam status pending (belum diproses).
     */
    public function isPending(): bool
    {
        return $this->status_usulan === 'pending';
    }

    /**
     * Cek apakah usulan sudah disetujui oleh Super Admin.
     */
    public function isDisetujui(): bool
    {
        return $this->status_usulan === 'disetujui';
    }

    /**
     * Cek apakah usulan sudah ditolak oleh Super Admin.
     */
    public function isDitolak(): bool
    {
        return $this->status_usulan === 'ditolak';
    }
}
