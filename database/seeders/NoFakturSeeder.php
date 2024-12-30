<?php

namespace Database\Seeders;

use App\Models\SetNoFaktur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class NoFakturSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        SetNoFaktur::create(['no_surat' => 'ENV', 'footer' => 'Silahkan isi terlebih dahulu', 'id_perusahaan' => $userId]);
    }
}
