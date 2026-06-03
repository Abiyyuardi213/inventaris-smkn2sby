<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_jurusan', 'kode_jurusan'])]
class Jurusan extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jurusans';

    protected static function booted(): void
    {
        static::creating(function (Jurusan $jurusan) {
            if (empty($jurusan->kode_jurusan)) {
                // Ambil singkatan 3 huruf kapital dari setiap kata pada nama_jurusan
                $words = explode(' ', $jurusan->nama_jurusan);
                $singkatan = strtoupper(implode('', array_map(
                    fn($word) => substr($word, 0, 1),
                    $words
                )));
                // Ambil hanya 3 karakter pertama jika lebih dari 3 kata
                $singkatan = substr($singkatan, 0, 3);

                // Hitung urutan: jumlah data yang sudah ada + 1
                $urutan = static::count() + 1;

                $jurusan->kode_jurusan = $singkatan . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
            }
        });

        static::deleting(function (Jurusan $jurusan) {
            if ($jurusan->ruangans()->exists()) {
                throw new \Exception('Unit Kerja tidak dapat dihapus karena masih memiliki ruangan terdaftar.');
            }
            if ($jurusan->inventaris()->exists()) {
                throw new \Exception('Unit Kerja tidak dapat dihapus karena masih memiliki data inventaris.');
            }
        });
    }

    /**
     * Relasi ke model Ruangan.
     */
    public function ruangans(): HasMany
    {
        return $this->hasMany(Ruangan::class);
    }

    /**
     * Relasi ke model Inventaris.
     */
    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class);
    }
}
