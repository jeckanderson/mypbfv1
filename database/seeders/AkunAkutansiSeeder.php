<?php

namespace Database\Seeders;

use App\Models\AkunAkutansi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AkunAkutansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Baca file SQL dari public
        $path = public_path('sql/akun_akutansi.sql');
        $sql = file_get_contents($path);

        // Eksekusi query dari file SQL
        DB::unprepared($sql);
    }
}