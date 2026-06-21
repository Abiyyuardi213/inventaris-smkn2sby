<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah kolom status_usulan dari enum lama ke enum baru dengan 5 nilai menggunakan raw SQL.
        // default tetap 'pending'.
        DB::statement("ALTER TABLE pengadaans MODIFY COLUMN status_usulan ENUM('pending', 'disetujui_admin', 'disetujui_kepsek', 'ditolak', 'ditolak_kepsek') NOT NULL DEFAULT 'pending'");

        // 2. Tambahkan 5 kolom baru untuk audit trail persetujuan Admin & Kepsek.
        Schema::table('pengadaans', function (Blueprint $table) {
            $table->uuid('approved_by_admin')->nullable();
            $table->timestamp('approved_by_admin_at')->nullable();
            $table->uuid('approved_by_kepsek')->nullable();
            $table->timestamp('approved_by_kepsek_at')->nullable();
            $table->text('catatan_kepsek')->nullable();

            // Setup foreign key constraints ke tabel users dengan onDelete('restrict')
            $table->foreign('approved_by_admin')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('approved_by_kepsek')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengadaans', function (Blueprint $table) {
            // Hapus foreign key constraint terlebih dahulu sebelum menjatuhkan kolom
            $table->dropForeign(['approved_by_admin']);
            $table->dropForeign(['approved_by_kepsek']);

            // Drop 5 kolom baru
            $table->dropColumn([
                'approved_by_admin',
                'approved_by_admin_at',
                'approved_by_kepsek',
                'approved_by_kepsek_at',
                'catatan_kepsek'
            ]);
        });

        // 3. Strategi Rollback Aman: 
        // Sebelum mengubah tipe enum kembali ke yang lama, update data status baru ke status terdekat yang valid di enum lama.
        // Jika tidak disesuaikan terlebih dahulu, MySQL akan merubah data status baru menjadi string kosong ('') saat enum diubah.
        DB::table('pengadaans')
            ->whereIn('status_usulan', ['disetujui_admin', 'disetujui_kepsek'])
            ->update(['status_usulan' => 'disetujui']);

        DB::table('pengadaans')
            ->where('status_usulan', 'ditolak_kepsek')
            ->update(['status_usulan' => 'ditolak']);

        // Kembalikan enum status_usulan ke 3 nilai asli menggunakan raw SQL
        DB::statement("ALTER TABLE pengadaans MODIFY COLUMN status_usulan ENUM('pending', 'disetujui', 'ditolak') NOT NULL DEFAULT 'pending'");
    }
};
