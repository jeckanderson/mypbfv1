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
        Schema::create('histori_stok', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_produk');
            $table->string('no_reff');
            $table->string('no_faktur');
            $table->string('no_batch');
            $table->string('exp_date');
            $table->string('suplier_pelanggan')->nullable();
            $table->string('id_gudang');
            $table->string('id_rak');
            $table->string('id_sub_rak');
            $table->string('sumber_set_harga')->nullable();
            $table->string('id_set_harga')->nullable();
            $table->string('stok_masuk');
            $table->string('stok_keluar');
            $table->string('stok_akhir');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_stok');
    }
};
