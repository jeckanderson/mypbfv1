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
        Schema::create('produk_retur_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_user');
            $table->string('id_histori');
            $table->string('id_retur')->nullable();
            $table->string('id_penjualan');
            $table->string('id_produk');
            $table->string('id_produk_penjualan');
            $table->string('qty_retur');
            $table->string('hpp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_retur_penjualan');
    }
};