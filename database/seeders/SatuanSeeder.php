<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        Satuan::create(['satuan' => 'Karton', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Box', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Botol', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Pcs', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Tube', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Flash', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Pack', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Vial', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Ampul', 'id_perusahaan' => $userId]);
        Satuan::create(['satuan' => 'Sachet', 'id_perusahaan' => $userId]);
    }
}
