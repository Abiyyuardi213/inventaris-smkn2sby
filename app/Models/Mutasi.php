<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'nomor_mutasi',
    'inventaris_id',
    'ruangan_asal_id',
    'ruangan_tujuan_id',
    'jumlah_dipindah',
    'tanggal_mutasi',
    'keterangan_pindah',
    'penanggung_jawab',
    'user_id'
])]
class Mutasi extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mutasis';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_mutasi' => 'date',
            'jumlah_dipindah' => 'integer',
        ];
    }

    /**
     * Relasi ke model Inventaris.
     */
    public function inventaris(): BelongsTo
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }

    /**
     * Relasi ke model Ruangan Asal.
     */
    public function ruanganAsal(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_asal_id');
    }

    /**
     * Relasi ke model Ruangan Tujuan.
     */
    public function ruanganTujuan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_tujuan_id');
    }

    /**
     * Relasi ke model User (aktor mutasi).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
