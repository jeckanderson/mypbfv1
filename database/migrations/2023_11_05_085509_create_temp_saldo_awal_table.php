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
        Schema::create('temp_saldo_awal', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_akun');
            $table->string('jenis_akun');
            $table->string('no_reff')->nullable();
            $table->string('saldo');
            $table->string('tipe_saldo');
            $table->string('saldo_sebelum');
            $table->string('saldo_sesudah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_saldo_awal');
    }
};
