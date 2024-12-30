<?php

namespace Database\Seeders;

use App\Models\SubGolongan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class SubGolonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        SubGolongan::create(['sub_golongan' => 'Obat Bebas', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Bebas Terbatas', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Keras', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Fitofarmaka', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Herbal Terstandar', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Herbal Jamu', 'id_perusahaan' => $userId]);
        SubGolongan::create(['sub_golongan' => 'Obat Narkotika', 'id_perusahaan' => $userId]);
    }
}