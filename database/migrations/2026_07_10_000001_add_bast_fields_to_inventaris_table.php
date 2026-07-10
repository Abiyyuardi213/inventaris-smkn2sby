<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->string('bahan')->nullable()->after('spesifikasi');
            $table->string('warna')->nullable()->after('bahan');
            $table->string('nama_penyedia')->nullable()->after('sumber_dana');
            $table->string('nomor_surat_bast')->nullable()->after('nama_penyedia');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn([
                'bahan',
                'warna',
                'nama_penyedia',
                'nomor_surat_bast',
            ]);
        });
    }
};
