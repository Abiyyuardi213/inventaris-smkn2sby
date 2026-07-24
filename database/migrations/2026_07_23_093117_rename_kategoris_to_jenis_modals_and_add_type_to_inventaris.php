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
        // 1. Drop foreign keys first (only if DB connection is not SQLite)
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('inventaris', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
            });
            Schema::table('pengadaans', function (Blueprint $table) {
                $table->dropForeign(['kategori_id']);
            });
        }

        // 2. Rename the table
        Schema::rename('kategoris', 'jenis_modals');

        // 3. Rename columns in the renamed table
        Schema::table('jenis_modals', function (Blueprint $table) {
            $table->renameColumn('nama_kategori', 'nama_jenis_modal');
            $table->renameColumn('kode_kategori', 'kode_jenis_modal');
        });

        // 4. Rename column in other tables and add new type column to inventaris
        Schema::table('inventaris', function (Blueprint $table) {
            $table->renameColumn('kategori_id', 'jenis_modal_id');
            $table->string('type')->nullable()->after('merek');
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            $table->renameColumn('kategori_id', 'jenis_modal_id');
        });

        // 5. Restore foreign keys referencing the new table
        Schema::table('inventaris', function (Blueprint $table) {
            $table->foreign('jenis_modal_id')
                  ->references('id')
                  ->on('jenis_modals')
                  ->onDelete('restrict');
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            $table->foreign('jenis_modal_id')
                  ->references('id')
                  ->on('jenis_modals')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('inventaris', function (Blueprint $table) {
                $table->dropForeign(['jenis_modal_id']);
            });
            Schema::table('pengadaans', function (Blueprint $table) {
                $table->dropForeign(['jenis_modal_id']);
            });
        }

        Schema::table('inventaris', function (Blueprint $table) {
            $table->renameColumn('jenis_modal_id', 'kategori_id');
            $table->dropColumn('type');
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            $table->renameColumn('jenis_modal_id', 'kategori_id');
        });

        Schema::table('jenis_modals', function (Blueprint $table) {
            $table->renameColumn('nama_jenis_modal', 'nama_kategori');
            $table->renameColumn('kode_jenis_modal', 'kode_kategori');
        });

        Schema::rename('jenis_modals', 'kategoris');

        Schema::table('inventaris', function (Blueprint $table) {
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('restrict');
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('restrict');
        });
    }
};
