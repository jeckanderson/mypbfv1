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
        Schema::table('hutang_pengguna',function(Blueprint $table){
            $table->nullableMorphs('sourceable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hutang_pengguna',function(Blueprint $table){
            $table->dropMorphs('sourceable');
        });
    }
};