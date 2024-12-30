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
        Schema::create('mutasi_stok', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_histori');
            $table->string('id_produk');
            $table->string('sumber');
            $table->string('id_sumber');
            $table->string('gudang_asal');
            $table->string('rak_asal');
            $table->string('sub_rak_asal');
            $table->string('jumlah_mutasi');
            $table->string('gudang_sesudah');
            $table->string('rak_sesudah');
            $table->string('sub_rak_sesudah');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_stok');
    }
};
