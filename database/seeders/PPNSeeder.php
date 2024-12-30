<?php

namespace Database\Seeders;

use App\Models\PPN;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class PPNSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = Auth::id() ?: 1;

        PPN::create(['ppn' => 11, 'id_perusahaan' => $userId]);
    }
}
