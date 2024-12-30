<?php

namespace Database\Seeders;

use App\Models\PasswordAkses;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PasswordAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PasswordAkses::create(['type' => 'open-price', 'email' => 'cscelesta@gmail.com', 'password' => Hash::make('admin123')]);
    }
}