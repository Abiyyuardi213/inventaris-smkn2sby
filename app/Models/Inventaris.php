<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Models\Peminjaman;

#[Fillable([
    'kode_inventaris',
    'nama_barang',
    'merek',
    'spesifikasi',
    'kategori_id',
    'jurusan_id',
    'ruangan_id',
    'jumlah_total',
    'kondisi',
    'tanggal_pengadaan'
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
            'tanggal_pengadaan' => 'date',
            'jumlah_total' => 'integer',
        ];
    }

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
