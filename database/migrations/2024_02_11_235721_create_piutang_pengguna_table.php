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
        Schema::create('piutang_pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_penjualan');
            $table->string('sumber')->nullable();
            $table->string('id_bp')->nullable();
            $table->string('id_pelanggan');
            $table->string('nominal_bayar');
            $table->string('total_hutang');
            $table->string('sisa_hutang');
            $table->string('sourceable_type')->nullable();
            $table->bigInteger('sourceable_id')->nullable();
            $table->string('detailable_type')->nullable();
            $table->bigInteger('detailable_id')->nullable();
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
        Schema::dropIfExists('piutang_pengguna');
    }
};
