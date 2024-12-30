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
        Schema::create('kontrabon', function (Blueprint $table) {
            $table->id();
            $table->string('id_perusahaan');
            $table->string('no_reff');
            $table->string('tgl_input');
            $table->string('pelanggan');
            $table->string('sales');
            $table->string('id_piutang');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kontrabon');
    }
};