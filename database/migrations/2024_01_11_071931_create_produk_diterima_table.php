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
        Schema::create('produk_diterima', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_terima_barang')->nullable();
            $table->string('id_produk');
            $table->string('id_sp');
            $table->string('id_pembelian');
            $table->string('id_order');
            $table->string('id_histori')->nullable();
            $table->string('diterima')->nullable();
            $table->string('no_batch')->nullable();
            $table->string('tgl_exp_date')->nullable();
            $table->string('gudang')->nullable();
            $table->string('rak')->nullable();
            $table->string('sub_rak')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_diterima');
    }
};
