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
        Schema::create('sp_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('tgl_input');
            $table->string('no_reff');
            $table->string('tgl_sp');
            $table->string('no_sp');
            $table->string('pelanggan');
            $table->string('sales');
            $table->string('tipe_sp');
            $table->string('kirim_cek_sp')->default(0);
            $table->string('status_cek')->default(0);
            $table->string('kirim_penjualan')->default(0);
            $table->string('keterangan')->nullable();
            $table->string('keterangan_cek_sp')->nullable();
            $table->string('sumber');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_penjualan');
    }
};
