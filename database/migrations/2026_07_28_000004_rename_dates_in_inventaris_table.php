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
            if (Schema::hasColumn('inventaris', 'tanggal_pengadaan') && !Schema::hasColumn('inventaris', 'tanggal_pembayaran')) {
                $table->renameColumn('tanggal_pengadaan', 'tanggal_pembayaran');
            }
        });

        Schema::table('inventaris', function (Blueprint $table) {
            if (Schema::hasColumn('inventaris', 'tanggal_bast') && !Schema::hasColumn('inventaris', 'tanggal_pengadaan')) {
                $table->renameColumn('tanggal_bast', 'tanggal_pengadaan');
            }
        });

        Schema::table('inventaris', function (Blueprint $table) {
            $table->date('tanggal_pembayaran')->nullable()->change();
            $table->date('tanggal_pengadaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            if (Schema::hasColumn('inventaris', 'tanggal_pengadaan') && !Schema::hasColumn('inventaris', 'tanggal_bast')) {
                $table->renameColumn('tanggal_pengadaan', 'tanggal_bast');
            }
        });

        Schema::table('inventaris', function (Blueprint $table) {
            if (Schema::hasColumn('inventaris', 'tanggal_pembayaran') && !Schema::hasColumn('inventaris', 'tanggal_pengadaan')) {
                $table->renameColumn('tanggal_pembayaran', 'tanggal_pengadaan');
            }
        });
    }
};
