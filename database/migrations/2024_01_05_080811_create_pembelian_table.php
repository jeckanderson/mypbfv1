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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_sp')->unique();
            $table->string('no_reff')->unique();
            $table->string('no_sp');
            $table->string('tgl_input');
            $table->string('tgl_faktur');
            $table->string('inc_ppn');
            $table->string('suplier');
            $table->string('no_faktur');
            $table->string('kredit')->nullable();
            $table->string('jumlah_hari')->nullable();
            $table->string('tempo_kredit')->nullable();
            $table->string('subtotal');
            $table->string('diskon');
            $table->string('hasil_diskon');
            $table->string('dpp');
            $table->string('ppn');
            $table->string('biaya1');
            $table->string('akun_biaya1')->nullable();
            $table->string('biaya2');
            $table->string('akun_biaya2')->nullable();
            $table->string('total_tagihan');
            $table->string('akun_bayar')->nullable();
            $table->string('jumlah_bayar');
            $table->string('no_faktur_pajak')->nullable();
            $table->string('tgl_faktur_pajak')->nullable();
            $table->string('kompensasi_pajak')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian');
    }
};
