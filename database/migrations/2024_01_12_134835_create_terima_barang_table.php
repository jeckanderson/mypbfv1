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
        Schema::create('terima_barang', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_pembelian');
            $table->string('id_sp');
            $table->string('no_reff');
            $table->string('tanggal');
            $table->string('no_faktur');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terima_barang');
    }
};
