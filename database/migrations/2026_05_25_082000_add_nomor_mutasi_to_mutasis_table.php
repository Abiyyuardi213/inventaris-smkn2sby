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
        Schema::table('mutasis', function (Blueprint $table) {
            $table->string('nomor_mutasi')->nullable()->unique()->after('id');
        });

        // Populate existing mutasi records with a default unique number
        $mutasis = \DB::table('mutasis')->get();
        foreach ($mutasis as $index => $m) {
            $dateStr = date('Ymd', strtotime($m->created_at));
            $newNomor = 'MUT-' . $dateStr . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            \DB::table('mutasis')->where('id', $m->id)->update(['nomor_mutasi' => $newNomor]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mutasis', function (Blueprint $table) {
            $table->dropColumn('nomor_mutasi');
        });
    }
};
