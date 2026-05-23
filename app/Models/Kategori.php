<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_kategori', 'kode_kategori'])]
class Kategori extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kategoris';

    protected static function booted(): void
    {
        static::creating(function (Kategori $kategori) {
            if (empty($kategori->kode_kategori)) {
                // Ambil singkatan 3 huruf kapital dari setiap kata pada nama_kategori
                $words = explode(' ', $kategori->nama_kategori);
                $singkatan = strtoupper(implode('', array_map(
                    fn($word) => substr($word, 0, 1),
                    $words
                )));
                // Ambil hanya 3 karakter pertama jika lebih dari 3 kata
                $singkatan = substr($singkatan, 0, 3);

                // Hitung urutan: jumlah data yang sudah ada + 1
                $urutan = static::count() + 1;

                $kategori->kode_kategori = $singkatan . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            }
        });

        static::deleting(function (Kategori $kategori) {
            // TODO: relasi ke Inventaris
            if ($kategori->inventaris()->exists()) {
                throw new \Exception('Kategori tidak dapat dihapus karena masih digunakan oleh data inventaris.');
            }
        });
    }

    // TODO: relasi ke Inventaris
    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class);
    }
}
