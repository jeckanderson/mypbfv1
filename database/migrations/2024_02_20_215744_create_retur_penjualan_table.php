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
        Schema::create('retur_penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_penjualan');
            $table->string('id_histori');
            $table->string('no_reff');
            $table->string('pelanggan');
            $table->string('sales');
            $table->string('no_faktur');
            $table->string('tgl_input');
            $table->string('total_piutang');
            $table->string('sisa_piutang')->nullable();
            $table->string('uang_retur')->nullable();
            $table->string('akun');
            $table->string('dpp');
            $table->string('ppn');
            $table->string('total');
            $table->string('no_seri_pajak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_penjualan');
    }
};