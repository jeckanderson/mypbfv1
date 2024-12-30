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
        Schema::create('produk_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_pembelian');
            $table->string('id_sp');
            $table->string('id_order');
            $table->string('id_produk');
            $table->string('qty_faktur');
            $table->string('harga');
            $table->string('disc_1');
            $table->string('disc_2');
            $table->string('total');
            $table->string('hpp_final');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_pembelian');
    }
};
