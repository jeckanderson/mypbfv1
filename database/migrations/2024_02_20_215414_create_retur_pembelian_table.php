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
        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_pembelian');
            $table->string('id_histori');
            $table->string('no_reff');
            $table->string('id_suplier');
            $table->string('tgl_input');
            $table->string('no_faktur');
            $table->string('no_reff_tb');
            $table->string('total_hutang');
            $table->string('sisa_hutang')->nullable();
            $table->string('uang_retur')->nullable();
            $table->string('akun');
            $table->string('dpp');
            $table->string('ppn');
            $table->string('total');
            $table->string('no_seri_pajak');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('retur_pembelian');
    }
};