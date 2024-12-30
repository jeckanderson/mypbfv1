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
        Schema::create('hutang_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_pembelian');
            $table->string('id_suplier');
            $table->string('sumber')->nullable();
            $table->string('id_bh')->nullable();
            $table->string('nominal_bayar');
            $table->string('total_hutang');
            $table->string('sisa_hutang');
            $table->bigInteger('akun_akutansi_id')->references('id')
                ->on('akun_akutansi')
                ->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_pengguna');
    }
};
