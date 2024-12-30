<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            PPNSeeder::class,
            PasswordAksesSeeder::class,
            JabatanSeeder::class,
            NoFakturSeeder::class,
            ProfileSeeder::class,
            SatuanSeeder::class,
            GolonganSeeder::class,
            SubGolonganSeeder::class,
            JenisObatBarangSeeder::class,
            GudangSeeder::class,
            RakSeeder::class,
            KelompokSeeder::class,
            SubRakSeeder::class,
            ProdusenSeeder::class,
            AkunAkutansiSeeder::class,
            DaftarObatSeeder::class,
        ]);
    }
}
