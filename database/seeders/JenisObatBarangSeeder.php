<?php

namespace Database\Seeders;

use App\Models\JenisObatBarang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class JenisObatBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        JenisObatBarang::create(['jenis' => 'Obat Bebas', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Bebas terbatas', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Keras', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Fitofarmaka', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Herbal Terstandar', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Herbal Jamu', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Narkotika', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat OOT', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Prekursor', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Obat Psikotropika', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'BHP', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Alkes', 'id_perusahaan' => $userId]);
        JenisObatBarang::create(['jenis' => 'Lain-lain', 'id_perusahaan' => $userId]);
    }
}
