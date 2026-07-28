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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_inventaris')->unique();
            $table->string('nama_barang');
            $table->string('merek');
            $table->text('spesifikasi');
            
            $table->uuid('kategori_id');
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('restrict');

            $table->uuid('jurusan_id');
            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('jurusans')
                  ->onDelete('restrict');

            $table->uuid('ruangan_id');
            $table->foreign('ruangan_id')
                  ->references('id')
                  ->on('ruangans')
                  ->onDelete('restrict');

            $table->integer('jumlah_total');
            $table->enum('kondisi', ['baik', 'layak', 'rusak']);
            $table->date('tanggal_pengadaan')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
