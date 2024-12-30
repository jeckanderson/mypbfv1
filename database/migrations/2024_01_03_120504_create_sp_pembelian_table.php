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
        Schema::create('sp_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('id_suplier');
            $table->string('no_reff');
            $table->string('tgl_sp');
            $table->string('tipe_sp');
            $table->string('no_sp');
            $table->string('id_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp_pembelian');
    }
};
