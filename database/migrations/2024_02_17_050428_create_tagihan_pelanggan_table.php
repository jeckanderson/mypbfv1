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
        Schema::create('tagihan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('tgl_input');
            $table->string('no_reff');
            $table->string('kolektor');
            $table->string('area_rayon');
            $table->string('id_piutang');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_pelanggan');
    }
};
