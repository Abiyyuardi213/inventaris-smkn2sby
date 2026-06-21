<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            // Primary key menggunakan UUID, bukan auto-increment
            $table->uuid('id')->primary();

            // Nama barang yang diusulkan untuk diadakan
            $table->string('nama_barang_usulan');

            // FK ke kategoris — restrict agar kategori tidak bisa dihapus
            // selama masih ada usulan pengadaan yang mereferensikannya
            $table->uuid('kategori_id');
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('restrict');

            // FK ke jurusans — restrict, jurusan pengusul tidak boleh dihapus
            // jika masih terdapat usulan yang belum diselesaikan
            $table->uuid('jurusan_id');
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('jurusans')
                  ->onDelete('restrict');

            // Jumlah unit barang yang diusulkan, tidak boleh negatif
            $table->unsignedInteger('jumlah');

            // Perkiraan harga total, menggunakan bigInteger untuk nominal besar
            // (nilai dalam Rupiah, unsigned agar tidak negatif)
            $table->unsignedBigInteger('perkiraan_harga');

            // Alasan/justifikasi pengadaan yang ditulis oleh pengusul
            $table->text('alasan_pengadaan');

            // Status alur persetujuan:
            //   pending   → baru diusulkan, menunggu review Super Admin
            //   disetujui → disetujui oleh Super Admin
            //   ditolak   → ditolak oleh Super Admin
            // Default 'pending' karena setiap usulan baru selalu dimulai dari status ini
            $table->enum('status_usulan', ['pending', 'disetujui', 'ditolak'])->default('pending');

            // FK ke users — mencatat siapa (Admin Sarpras) yang mengajukan usulan
            // restrict agar akun pengusul tidak bisa dihapus selama masih ada usulan
            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key constraint sebelum drop tabel
        // agar tidak terjadi error referential integrity
        Schema::dropIfExists('pengadaans');
    }
};
