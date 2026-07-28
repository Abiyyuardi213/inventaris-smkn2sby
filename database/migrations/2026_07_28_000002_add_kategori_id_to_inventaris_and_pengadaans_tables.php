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
            if (!Schema::hasColumn('inventaris', 'kategori_id')) {
                $table->uuid('kategori_id')->nullable()->after('jenis_modal_id');
            }
            $table->foreign('kategori_id', 'fk_inventaris_kategori_id')
                ->references('id')
                ->on('kategoris')
                ->nullOnDelete();
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            if (!Schema::hasColumn('pengadaans', 'kategori_id')) {
                $table->uuid('kategori_id')->nullable()->after('jenis_modal_id');
            }
            $table->foreign('kategori_id', 'fk_pengadaans_kategori_id')
                ->references('id')
                ->on('kategoris')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropForeign('fk_inventaris_kategori_id');
            $table->dropColumn('kategori_id');
        });

        Schema::table('pengadaans', function (Blueprint $table) {
            $table->dropForeign('fk_pengadaans_kategori_id');
            $table->dropColumn('kategori_id');
        });
    }
};
