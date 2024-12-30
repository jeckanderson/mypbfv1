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
        Schema::create('produk_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_sp_penjualan');
            $table->string('id_penjualan')->nullable();
            $table->string('id_produk');
            $table->string('id_user');
            $table->string('id_histori');
            $table->string('qty_sp');
            $table->string('satuan');
            $table->string('sumber')->nullable();
            $table->string('id_sumber')->nullable();
            $table->string('batch')->nullable();
            $table->string('exp_date')->nullable();
            $table->string('stok')->nullable();
            $table->string('gudang')->nullable();
            $table->string('rak')->nullable();
            $table->string('sub_rak')->nullable();
            $table->string('qty')->nullable();
            $table->string('harga')->nullable();
            $table->string('disc_1')->nullable();
            $table->string('disc_2')->nullable();
            $table->string('total')->nullable();
            $table->string('modal_produk')->nullable();
            $table->string('total_modal')->nullable();
            $table->string('sp_terbuat')->default(0);
            $table->string('produk_tambahan')->default(0);
            $table->string('masuk_penjualan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_penjualan');
    }
};