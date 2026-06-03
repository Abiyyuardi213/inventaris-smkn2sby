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
          Schema::create('peminjamans', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('nama_peminjam');
            $table->string('instansi')->nullable();
            $table->string('kontak')->nullable();

            $table->uuid('inventaris_id');
            $table->foreign('inventaris_id')
                ->references('id')
                ->on('inventaris')
                ->onDelete('restrict');

            $table->integer('jumlah_pinjam')->default(1);
            $table->date('tanggal_pinjam');
            $table->date('tanggal_estimasi_kembali')->nullable();

            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');

            // Optional: record staff who processed the peminjaman
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->timestamps();
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
