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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('no_reff');
            $table->string('no_faktur');
            $table->string('no_sp');
            $table->string('id_sp');
            $table->string('tgl_input');
            $table->string('tgl_faktur');
            $table->string('pelanggan');
            $table->string('sales');
            $table->string('kredit');
            $table->string('tempo_kredit');
            $table->string('no_seri_pajak');
            $table->string('subtotal');
            $table->string('diskon');
            $table->string('hasil_diskon');
            $table->string('dpp');
            $table->string('ppn');
            $table->string('biaya1');
            $table->string('akun_biaya1');
            $table->string('biaya2');
            $table->string('akun_biaya2');
            $table->string('total_tagihan');
            $table->string('akun_bayar')->nullable();
            $table->string('jumlah_bayar');
            $table->string('total_hutang');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
