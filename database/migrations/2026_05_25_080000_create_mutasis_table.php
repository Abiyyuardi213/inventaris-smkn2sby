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
        Schema::create('mutasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('inventaris_id');
            $table->foreign('inventaris_id')
                  ->references('id')
                  ->on('inventaris')
                  ->onDelete('restrict');

            $table->uuid('ruangan_asal_id');
            $table->foreign('ruangan_asal_id')
                  ->references('id')
                  ->on('ruangans')
                  ->onDelete('restrict');

            $table->uuid('ruangan_tujuan_id');
            $table->foreign('ruangan_tujuan_id')
                  ->references('id')
                  ->on('ruangans')
                  ->onDelete('restrict');

            $table->integer('jumlah_dipindah');
            $table->date('tanggal_mutasi');
            $table->text('keterangan_pindah');

            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasis');
    }
};
