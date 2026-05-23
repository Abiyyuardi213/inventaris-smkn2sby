<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ruangans', function (Blueprint $table) {
            // Primary key menggunakan UUID, bukan auto-increment
            $table->uuid('id')->primary();

            // Foreign key ke tabel jurusans, tipe UUID agar sesuai dengan PK parent
            // onDelete('restrict'): mencegah penghapusan jurusan jika masih ada ruangan terkait
            $table->uuid('jurusan_id');
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('jurusans')
                  ->onDelete('restrict');

            $table->string('nama_ruangan');

            $table->timestamps();

            // Unique constraint kombinasi: satu nama ruangan tidak boleh duplikat dalam jurusan yang sama
            $table->unique(['jurusan_id', 'nama_ruangan']);
        });
    }

    public function down(): void
    {
        // Drop tabel child (ruangans) terlebih dahulu sebelum parent (jurusans)
        Schema::dropIfExists('ruangans');
    }
};
