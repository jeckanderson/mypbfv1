<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        Jabatan::create(['jabatan' => 'Direktur', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Supervisor', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Sales', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Apoteker', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Kolektor', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Ka. Gudang', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Ka. Keuangan', 'id_perusahaan' => $userId]);
        Jabatan::create(['jabatan' => 'Pengirim', 'id_perusahaan' => $userId]);
    }
}
