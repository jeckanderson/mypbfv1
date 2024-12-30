<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RenewPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel yang memiliki constraint foreign key
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();

        // Kosongkan tabel utama
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('users')->truncate();

        // Aktifkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            // Dashboard Admin
            'akses_dashboard_admin',

            // Profil Perusahaan
            'akses_profil_perusahaan',

            // Pajak Perusahaan
            'akses_pajak_perusahaan',

            // Jabatan
            'akses_jabatan',
            'tambah_jabatan',
            'aksi_jabatan',


            // Nama Pegawai
            'akses_nama_pegawai',
            'tambah_nama_pegawai',
            'aksi_nama_pegawai',

            // Set Akses
            'akses_set_akses',
            'tambah_set_akses',
            'aksi_set_akses',

            // User
            'akses_user',
            'tambah_user',
            'aksi_user',

            // Area Rayon
            'akses_area_rayon',
            'tambah_area_rayon',
            'aksi_area_rayon',

            // Sub Rayon
            'akses_sub_rayon',
            'tambah_sub_rayon',
            'aksi_sub_rayon',

            // Sales
            'akses_sales',
            'tambah_sales',
            'aksi_sales',

            // Target SPV
            'akses_target_spv',
            'tambah_target_spv',
            'aksi_target_spv',

            // Target Sales
            'akses_target_sales',
            'tambah_target_sales',
            'aksi_target_sales',

            // Target Produk
            'akses_target_produk',
            'tambah_target_produk',
            'aksi_target_produk',

            // Produk
            'akses_produk',
            'tambah_produk',
            'aksi_produk',

            // Satuan
            'akses_satuan',
            'tambah_satuan',
            'aksi_satuan',

            // Kategori
            'akses_kategori',
            'tambah_kategori',
            'aksi_kategori',

            // Golongan
            'akses_golongan',
            'tambah_golongan',
            'aksi_golongan',

            // Jenis Produk
            'akses_jenis_produk',
            'tambah_jenis_produk',
            'aksi_jenis_produk',

            // Nama Gudang
            'akses_nama_gudang',
            'tambah_nama_gudang',
            'aksi_nama_gudang',

            // Rak
            'akses_rak',
            'tambah_rak',
            'aksi_rak',

            // Sub Rak
            'akses_sub_rak',
            'tambah_sub_rak',
            'aksi_sub_rak',

            // Kelompok
            'akses_kelompok',
            'tambah_kelompok',
            'aksi_kelompok',

            // Pelanggan
            'akses_pelanggan',
            'tambah_pelanggan',
            'aksi_pelanggan',

            // Produsen
            'akses_produsen',
            'tambah_produsen',
            'aksi_produsen',

            // Supplier
            'akses_supplier',
            'tambah_supplier',
            'aksi_supplier',

            // Ekspedisi
            'akses_ekspedisi',
            'tambah_ekspedisi',
            'aksi_ekspedisi',

            // Akun Akuntansi
            'akses_akun_akuntansi',
            'tambah_akun_akuntansi',
            'aksi_akun_akuntansi',

            // Barcode Produk
            'akses_barcode_produk',

            // Barcode Pelanggan
            'akses_barcode_pelanggan',

            // Hutang Awal
            'akses_hutang_awal',
            'tambah_hutang_awal',
            'aksi_hutang_awal',

            // Piutang Awal
            'akses_piutang_awal',
            'tambah_piutang_awal',
            'aksi_piutang_awal',

            // Stok Awal
            'akses_stok_awal',
            'tambah_stok_awal',
            'aksi_stok_awal',

            // Saldo Awal
            'akses_saldo_awal',

            // Histori Stok
            'akses_histori_stok',

            // Stok Opname
            'akses_stok_opname',
            'tambah_stok_opname',
            'aksi_stok_opname',

            // Tambah Stok Masuk
            'akses_tambah_stok_masuk',

            // Mutasi Stok
            'akses_mutasi_stok',

            // Analisis Pareto ABC
            'akses_analisis_pareto_abc',

            // Analisis Venn
            'akses_analisis_ven',

            // Defecta
            'akses_defecta',
            'tambah_defecta',
            'aksi_defecta',

            // Pembuatan SP
            'akses_pembuatan_sp',

            // Pembelian
            'akses_pembelian',
            'tambah_pembelian',
            'aksi_pembelian',

            // Terima Barang
            'akses_terima_barang',
            'tambah_terima_barang',
            'aksi_terima_barang',

            // Retur Pembelian
            'akses_retur_pembelian',
            'tambah_retur_pembelian',
            'aksi_retur_pembelian',

            // SP Penjualan
            'akses_sp_penjualan',
            'tambah_sp_penjualan',
            'aksi_sp_penjualan',

            // Cek SP Penjualan
            'akses_cek_sp_penjualan',
            'tambah_cek_sp_penjualan',
            'aksi_cek_sp_penjualan',

            // Setting No Faktur
            'akses_setting_no_faktur',
            'tambah_setting_no_faktur',
            'aksi_setting_no_faktur',

            // Penjualan
            'akses_penjualan',
            'tambah_penjualan',
            'aksi_penjualan',

            // Retur Penjualan
            'akses_retur_penjualan',
            'tambah_retur_penjualan',
            'aksi_retur_penjualan',

            // Surat Jalan
            'akses_surat_jalan',
            'tambah_surat_jalan',
            'aksi_surat_jalan',

            // Kontra Bon
            'akses_kontra_bon',
            'tambah_kontra_bon',
            'aksi_kontra_bon',

            // Tagihan Pelanggan
            'akses_tagihan_pelanggan',
            'tambah_tagihan_pelanggan',
            'aksi_tagihan_pelanggan',

            // Pembayaran Hutang
            'akses_pembayaran_hutang',
            'tambah_pembayaran_hutang',
            'aksi_pembayaran_hutang',

            // Pembayaran Piutang
            'akses_pembayaran_piutang',
            'tambah_pembayaran_piutang',
            'aksi_pembayaran_piutang',

            // Mutasi Saldo
            'akses_mutasi_saldo',
            'tambah_mutasi_saldo',
            'aksi_mutasi_saldo',

            // Jurnal Akun
            'akses_jurnal_akun',
            'tambah_jurnal_akun',
            'aksi_jurnal_akun',

            // Jurnal Umum
            'akses_jurnal_umum',

            // Buku Besar
            'akses_buku_besar',

            // Neraca
            'akses_neraca',

            // Laba Rugi
            'akses_laba_rugi',

            // Pajak Masukan
            'akses_pajak_masukan',

            // Retur Pajak Masukan
            'akses_retur_pajak_masukan',

            // Pajak Keluaran
            'akses_pajak_keluaran',

            // Retur Pajak Keluaran
            'akses_retur_pajak_keluaran',

            // Reset
            'akses_reset',

            // Backup
            'akses_backup',

            // Produk
            'akses_laporan_produk',

            // Penjualan
            'akses_laporan_penjualan',

            // Pembelian
            'akses_laporan_pembelian',

            // Hutang
            'akses_laporan_hutang',

            // Piutang
            'akses_laporan_piutang',

            // Keuangan
            'akses_keuangan',

            // PBF
            'akses_pbf'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Membuat user dan memberikan permission
        User::create([
            'name' => 'Admin',
            'id_perusahaan' => '1',
            'email' => 'admin@gmail.com',
            'status' => 'main',
            'password' => Hash::make('admin123'),
        ])->givePermissionTo($permissions);
    }
}