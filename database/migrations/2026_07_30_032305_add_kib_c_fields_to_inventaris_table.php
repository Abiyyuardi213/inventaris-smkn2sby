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
        Schema::table('inventaris', function (Blueprint $table) {
            $table->string('konstruksi_bertingkat')->nullable()->after('warna');
            $table->string('konstruksi_beton')->nullable()->after('konstruksi_bertingkat');
            $table->decimal('luas_lantai', 12, 2)->nullable()->after('konstruksi_beton');
            $table->text('lokasi_alamat')->nullable()->after('luas_lantai');
            $table->date('dokumen_tanggal')->nullable()->after('lokasi_alamat');
            $table->string('dokumen_nomor')->nullable()->after('dokumen_tanggal');
            $table->decimal('luas_tanah', 12, 2)->nullable()->after('dokumen_nomor');
            $table->string('status_tanah')->nullable()->after('luas_tanah');
            $table->string('nomor_kode_tanah')->nullable()->after('status_tanah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn([
                'konstruksi_bertingkat',
                'konstruksi_beton',
                'luas_lantai',
                'lokasi_alamat',
                'dokumen_tanggal',
                'dokumen_nomor',
                'luas_tanah',
                'status_tanah',
                'nomor_kode_tanah',
            ]);
        });
    }
};
