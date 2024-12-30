<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class KelompokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        Kelompok::create(['kelompok' => 'APOTEK', 'id_perusahaan' => $userId]);
        Kelompok::create(['kelompok' => 'RUMAH SAKIT', 'id_perusahaan' => $userId]);
        Kelompok::create(['kelompok' => 'PUSKESMAS', 'id_perusahaan' => $userId]);
        Kelompok::create(['kelompok' => 'KLINIK', 'id_perusahaan' => $userId]);
        Kelompok::create(['kelompok' => 'INSTANSI PEMERINTAHAN', 'id_perusahaan' => $userId]);
    }
}
