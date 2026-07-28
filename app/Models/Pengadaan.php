<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'nama_barang_usulan',
    'jenis_modal_id',
    'kategori_id',
    'jurusan_id',
    'jumlah',
    'perkiraan_harga',
    'alasan_pengadaan',
    'status_usulan',
    'user_id',
    'approved_by_admin',
    'approved_by_admin_at',
    'approved_by_kepsek',
    'approved_by_kepsek_at',
    'catatan_kepsek',
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
     * - approved_by_admin_at: datetime
     * - approved_by_kepsek_at: datetime
     */
    protected $casts = [
        'perkiraan_harga' => 'integer',
        'jumlah'          => 'integer',
        'status_usulan'   => 'string',
        'approved_by_admin_at' => 'datetime',
        'approved_by_kepsek_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        /**
         * EVENT: deleting
         * Proteksi hapus — usulan hanya boleh dihapus selama masih berstatus 'pending'.
         * Jika sudah diproses (disetujui_admin/disetujui_kepsek/ditolak/ditolak_kepsek),
         * hapus diblokir karena data sudah menjadi bagian dari alur persetujuan.
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
         * Proteksi edit — setelah diproses (bukan pending), isi usulan tidak boleh diubah secara bebas.
         * Kami mengizinkan transisi status resmi:
         * a) Tahap 1 (Super Admin): status original 'pending' -> dirty columns: status_usulan, approved_by_admin, approved_by_admin_at
         * b) Tahap 2 (Kepsek): status original 'disetujui_admin' -> dirty columns: status_usulan, approved_by_kepsek, approved_by_kepsek_at, catatan_kepsek
         */
        static::updating(function (Pengadaan $pengadaan) {
            $statusAsli = $pengadaan->getOriginal('status_usulan');

            // Jika status asli bukan pending dan bukan disetujui_admin, tolak langsung semua perubahan
            if ($statusAsli !== 'pending' && $statusAsli !== 'disetujui_admin') {
                throw new \Exception(
                    'Usulan pengadaan tidak dapat diedit karena sudah diproses.'
                );
            }

            $kolomYangBerubah = array_keys($pengadaan->getDirty());

            // Validasi transisi tahap 1 (Super Admin)
            if ($statusAsli === 'pending') {
                $allowedStage1 = ['status_usulan', 'approved_by_admin', 'approved_by_admin_at'];
                if (array_diff($kolomYangBerubah, $allowedStage1) !== []) {
                    throw new \Exception(
                        'Usulan pengadaan tidak dapat diedit karena sudah diproses.'
                    );
                }
            }

            // Validasi transisi tahap 2 (Kepsek)
            if ($statusAsli === 'disetujui_admin') {
                $allowedStage2 = ['status_usulan', 'approved_by_kepsek', 'approved_by_kepsek_at', 'catatan_kepsek'];
                if (array_diff($kolomYangBerubah, $allowedStage2) !== []) {
                    throw new \Exception(
                        'Usulan pengadaan tidak dapat diedit karena sudah diproses.'
                    );
                }
            }
        });
    }

    // =========================================================================
    // RELASI LAMA
    // =========================================================================

    /**
     * Relasi ke model Jenis Modal.
     */
    public function jenisModal(): BelongsTo
    {
        return $this->belongsTo(JenisModal::class, 'jenis_modal_id');
    }

    /**
     * Relasi ke model Kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
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
     */
    public function pengusul(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // =========================================================================
    // RELASI BARU
    // =========================================================================

    /**
     * Relasi ke model User (Super Admin yang menyetujui usulan di tahap 1).
     */
    public function approvedByAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_admin');
    }

    /**
     * Relasi ke model User (Kepala Sekolah yang memproses usulan di tahap 2).
     */
    public function approvedByKepsek(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_kepsek');
    }

    // =========================================================================
    // HELPER METHODS — STATUS CHECK
    // =========================================================================

    /**
     * Cek apakah usulan masih dalam status pending (menunggu review Super Admin).
     */
    public function isPending(): bool
    {
        return $this->status_usulan === 'pending';
    }

    /**
     * Cek apakah usulan disetujui oleh Super Admin di tahap 1 (menunggu Kepsek).
     */
    public function isDisetujuiAdmin(): bool
    {
        return $this->status_usulan === 'disetujui_admin';
    }

    /**
     * Cek apakah usulan disetujui oleh Kepala Sekolah di tahap 2 (FINAL).
     */
    public function isDisetujuiKepsek(): bool
    {
        return $this->status_usulan === 'disetujui_kepsek';
    }

    /**
     * Cek apakah usulan ditolak oleh Super Admin di tahap 1 (FINAL).
     */
    public function isDitolak(): bool
    {
        return $this->status_usulan === 'ditolak';
    }

    /**
     * Cek apakah usulan ditolak oleh Kepala Sekolah di tahap 2 (FINAL).
     */
    public function isDitolakKepsek(): bool
    {
        return $this->status_usulan === 'ditolak_kepsek';
    }

    /**
     * Cek apakah usulan berstatus menunggu keputusan Kepala Sekolah.
     * Alias untuk isDisetujuiAdmin().
     */
    public function isMenungguKepsek(): bool
    {
        return $this->isDisetujuiAdmin();
    }

    /**
     * Cek apakah usulan sudah berada di status final (tidak bisa diproses lagi).
     */
    public function isFinal(): bool
    {
        return in_array($this->status_usulan, ['disetujui_kepsek', 'ditolak', 'ditolak_kepsek'], true);
    }
}
