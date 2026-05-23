<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            // Primary key menggunakan UUID, bukan auto-increment
            $table->uuid('id')->primary();

            // Kode unik per jurusan, di-generate otomatis (contoh: "TKJ-001", "RPL-002")
            $table->string('kode_jurusan')->unique();

            // Nama jurusan harus unik di seluruh tabel
            $table->string('nama_jurusan')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
