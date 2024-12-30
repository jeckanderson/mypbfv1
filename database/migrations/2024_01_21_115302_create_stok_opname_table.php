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
        Schema::create('stok_opname', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_histori');
            $table->string('sumber')->nullable();
            $table->string('id_sumber')->nullable();
            $table->string('tgl_so');
            $table->string('no_reff')->nullable();
            $table->string('id_produk');
            $table->string('no_batch');
            $table->string('exp_date');
            $table->string('stok_tercatat');
            $table->string('stok_real');
            $table->string('selisih_stok');
            $table->string('hpp');
            $table->string('nominal_selisih');
            $table->string('keterangan');
            $table->string('gudang');
            $table->string('rak');
            $table->string('sub_rak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opname');
    }
};