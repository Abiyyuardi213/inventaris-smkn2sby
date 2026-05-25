<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategoris', function (Blueprint $table) {
            // Primary key menggunakan UUID, bukan auto-increment
            $table->uuid('id')->primary();

            // Kode unik per kategori, di-generate otomatis (contoh: "ELK-001", "MBL-002")
            $table->string('kode_kategori')->unique();

            // Nama kategori harus unik di seluruh tabel
            $table->string('nama_kategori')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategoris');
    }
};
