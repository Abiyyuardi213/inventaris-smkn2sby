<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\Peminjaman;

#[Fillable([
    'kode_inventaris',
    'nama_barang',
    'merek',
    'type',
    'spesifikasi',
    'bahan',
    'warna',
    'jenis_modal_id',
    'kategori_id',
    'jurusan_id',
    'ruangan_id',
    'jumlah_total',
    'harga_satuan',
    'sumber_dana',
    'nama_penyedia',
    'nomor_surat_bast',
    'tanggal_pembayaran',
    'kondisi',
    'tanggal_pengadaan',
    'qr_code_path',
    'foto_url'
])]
class Inventaris extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inventaris';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_pembayaran' => 'date',
            'tanggal_pengadaan' => 'date',
            'jumlah_total' => 'integer',
            'harga_satuan' => 'integer',
        ];
    }

    /**
     * Boot logic for registering event hooks.
     */
    protected static function booted(): void
    {
        // Event created: generate QR code setelah model tersimpan ke DB (agar memiliki UUID)
        static::created(function (Inventaris $inventaris) {
            $inventaris->generateQrCode();
            $inventaris->saveQuietly();
        });

        // Event updated: regenerasi QR code setiap kali data diperbarui agar URL selalu up-to-date
        static::updated(function (Inventaris $inventaris) {
            $inventaris->generateQrCode();
            $inventaris->saveQuietly();
        });
    }

    /**
     * Generate QR Code for the inventaris item and save it in the storage disk.
     */
    public function generateQrCode(): void
    {
        $url = route('inventaris.show', $this->id);
        
        // Path relatif untuk disimpan di database (menggunakan SVG karena tidak bergantung pada Imagick)
        $relativePath = "qrcodes/inventaris/{$this->id}.svg";
        
        // Pastikan folder tujuan di disk public sudah siap
        if (!Storage::disk('public')->exists('qrcodes/inventaris')) {
            Storage::disk('public')->makeDirectory('qrcodes/inventaris');
        }
        
        // Generate QR code as SVG
        $qrCodeBytes = QrCode::format('svg')
            ->size(300)
            ->margin(1)
            ->generate($url);
            
        // Simpan file ke disk public
        Storage::disk('public')->put($relativePath, $qrCodeBytes);
        
        // Set path di model
        $this->qr_code_path = $relativePath;
    }

    public function getFotoPreviewUrlAttribute(): ?string
    {
        if (blank($this->foto_url)) {
            return null;
        }

        $fileId = $this->googleDriveFileId();

        if ($fileId === null) {
            return $this->foto_url;
        }

        return "https://drive.google.com/thumbnail?id={$fileId}&sz=w700";
    }

    public function googleDriveFileId(): ?string
    {
        if (blank($this->foto_url)) {
            return null;
        }

        if (preg_match('/\/file\/d\/([^\/]+)/', $this->foto_url, $matches)) {
            return $matches[1];
        }

        if (preg_match('/[?&]id=([^&]+)/', $this->foto_url, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function getHargaTotalAttribute(): int
    {
        return (int) $this->harga_satuan * (int) $this->jumlah_total;
    }

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
     * Relasi ke model Ruangan.
     */
    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class);
    }

    /**
     * Relasi ke model Peminjaman (riwayat peminjaman eksternal).
     */
    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'inventaris_id');
    }
}
