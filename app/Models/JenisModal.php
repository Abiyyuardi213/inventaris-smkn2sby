<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_jenis_modal', 'kode_jenis_modal'])]
class JenisModal extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jenis_modals';

    protected static function booted(): void
    {
        static::creating(function (JenisModal $jenisModal) {
            if (empty($jenisModal->kode_jenis_modal)) {
                // Ambil singkatan 3 huruf kapital dari setiap kata pada nama_jenis_modal
                $words = explode(' ', $jenisModal->nama_jenis_modal);
                $singkatan = strtoupper(implode('', array_map(
                    fn($word) => substr($word, 0, 1),
                    $words
                )));
                // Ambil hanya 3 karakter pertama jika lebih dari 3 kata
                $singkatan = substr($singkatan, 0, 3);

                // Hitung urutan: jumlah data yang sudah ada + 1
                $urutan = static::count() + 1;

                $jenisModal->kode_jenis_modal = $singkatan . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            }
        });

        static::deleting(function (JenisModal $jenisModal) {
            if ($jenisModal->inventaris()->exists()) {
                throw new \Exception('Jenis Modal tidak dapat dihapus karena masih digunakan oleh data inventaris.');
            }
        });
    }

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'jenis_modal_id');
    }
}
