<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['jurusan_id', 'nama_ruangan'])]
class Ruangan extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ruangans';

    protected static function booted(): void
    {
        static::deleting(function (Ruangan $ruangan) {
            // TODO: relasi ke Inventaris
            if ($ruangan->inventaris()->exists()) {
                throw new \Exception('Ruangan tidak dapat dihapus karena masih memiliki data inventaris.');
            }
        });
    }

    /**
     * Relasi ke model Jurusan.
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    // TODO: relasi ke Inventaris
    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class);
    }
}
