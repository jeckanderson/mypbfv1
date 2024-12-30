<?php

use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RakController;
use App\Http\Controllers\PajakController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\NeracaController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SubRakController;
use App\Livewire\Utilities\Pbf\Distribusi;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetUserController;
use App\Http\Controllers\SuplierController;

use App\Http\Controllers\AkutansiController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\KelompokController;
use App\Http\Controllers\KeuanganController;

use App\Http\Controllers\ProdusenController;
use App\Http\Controllers\SetAksesController;
use App\Http\Controllers\StokAwalController;
use App\Http\Controllers\SubRayonController;
use App\Http\Controllers\AreaRayonController;
use App\Http\Controllers\BukuBesarController;


use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\SaldoAwalController;
use App\Http\Controllers\TargetSPVController;
use App\Http\Controllers\HutangAwalController;
use App\Http\Controllers\ObatBarangController;
use App\Http\Controllers\PersediaanController;
use App\Livewire\Penjualan\SettingNomorFaktur;
use App\Http\Controllers\NeracaLajurController;
use App\Http\Controllers\PembuatanSPController;
use App\Http\Controllers\PiutangAwalController;
use App\Http\Controllers\SubGolonganController;
use App\Http\Controllers\TargetSalesController;
use App\Http\Controllers\AkunAkutansiController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CetakTransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanPajakController;
use App\Http\Controllers\SetHargaJualController;
use App\Http\Controllers\TargetProdukController;
use App\Http\Controllers\TerimaBarangController;
use App\Http\Controllers\JenisObatBarangController;
use App\Http\Controllers\PasswordManagerController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TambahPembelianController;
use App\Http\Controllers\utilities\pbf\ReportPBFController;
use App\Http\Controllers\utilities\keuangan\KasBankController;

use App\Http\Controllers\utilities\produk\ExpProdukController;

use App\Http\Controllers\utilities\produk\PriceListController;
use App\Http\Controllers\utilities\pbf\WasDistribusiController;
use App\Http\Controllers\utilities\pbf\WasPenerimaanController;

use App\Http\Controllers\utilities\hutang\KartuHutangController;
use App\Http\Controllers\utilities\hutang\RekapHutangController;
use App\Http\Controllers\utilities\piutang\KartuPiutangController;
use App\Http\Controllers\utilities\piutang\RekapPiutangController;
use App\Http\Controllers\utilities\pembelian\SpPembelianController;
use App\Http\Controllers\utilities\penjualan\SpPenjualanController;
use App\Http\Controllers\utilities\penjualan\SpPenjualansController;
use App\Http\Controllers\utilities\produk\NilaiPersediaanController;
use App\Http\Controllers\utilities\hutang\HutangJatuhTempoController;
use App\Http\Controllers\utilities\hutang\PembayaranHutangController;
use App\Http\Controllers\utilities\penjualan\SpVsPenjualanController;
use App\Http\Controllers\utilities\penjualan\RekapPenjualanController;
use App\Http\Controllers\utilities\penjualan\ReturPenjualanController;
use App\Http\Controllers\utilities\piutang\PembayaranPiutangController;

use App\Http\Controllers\utilities\piutang\PiutangJatuhTempoController;
use App\Http\Controllers\utilities\penjualan\DetailLabaFakturController;
use App\Http\Controllers\utilities\penjualan\DetailSpPenjualanController;
use App\Http\Controllers\utilities\pembelian\DetailTerimaBarangController;
use App\Http\Controllers\utilities\pembelian\PembelianPerFakturController;
use App\Http\Controllers\utilities\pembelian\PembelianPerProdukController;
use App\Http\Controllers\utilities\penjualan\PenjualanPerFakturController;
use App\Http\Controllers\utilities\penjualan\PenjualanPerProdukController;
use App\Http\Controllers\utilities\pembelian\EstimasiSpPembelianController;
use App\Http\Controllers\utilities\penjualan\LabaPenjualanFakturController;
use App\Http\Controllers\utilities\penjualan\LabaPenjualanProdukController;
use App\Http\Controllers\utilities\pembelian\PembelianPerSupplierController;
use App\Http\Controllers\utilities\pembelian\DetailPembelianFakturController;
use App\Http\Controllers\utilities\penjualan\DetailPenjualanFakturController;
use App\Http\Controllers\utilities\penjualan\PenjualanPerPelangganController;
use App\Http\Controllers\utilities\pembelian\SpPembelianVsPembelianController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';


Route::middleware(['auth'])->group(function () {
    //dashboard
    Route::get('/', [DashboardController::class, 'admin'])->name('x.admin');
    Route::get('/dashboard-sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
    Route::get('/dashboard-kasir', [DashboardController::class, 'kasir'])->name('dashboard.kasir');
    Route::get('/dashboard-apoteker', [DashboardController::class, 'apoteker'])->name('dashboard.apoteker');
    Route::get('/dashboard-keuangan', [DashboardController::class, 'keuangan'])->name('dashboard.keuangan');
    Route::get('/dashboard-gudang', [DashboardController::class, 'gudang'])->name('dashboard.gudang');

    //profile
    Route::get('/profil-perusahaan', [ProfileController::class, 'index'])->name('profile');
    Route::post('/update-profil-perusahaan', [ProfileController::class, 'updateProfile'])->name('update.profile');
    Route::post('/get-cities/{province_id}', [ProfileController::class, 'getCities'])->name('getCities');

    //pajak
    Route::get('/pajak-perusahaan', [PajakController::class, 'index'])->name('pajak');
    Route::post('/update-pajak-perusahaan', [PajakController::class, 'updatePajak'])->name('update.pajak');
    Route::post('/delete-pajak-perusahaan/{id}', [PajakController::class, 'deletePajak'])->name('delete.pajak');

    //jabatan
    Route::get('/jabatan', [JabatanController::class, 'index'])->name('jabatan');
    Route::post('/tambah-jabatan', [JabatanController::class, 'createJabatan'])->name('create.jabatan');
    Route::post('/edit-jabatan/{id}', [JabatanController::class, 'editJabatan'])->name('edit.jabatan');
    Route::post('/delete-jabatan/{id}', [JabatanController::class, 'deleteJabatan'])->name('delete.jabatan');

    //nama pegawai
    Route::get('/nama-pegawai', [PegawaiController::class, 'index'])->name('pegawai');
    Route::get('/pegawai-download-excel', function () {
        return view('excel.nama_pegawai');
    });
    Route::get('/pegawai-download-pdf', [PegawaiController::class, 'export_pegawai_pdf'])->name('export_pegawai_pdf');
    Route::post('/tambah-nama-pegawai', [PegawaiController::class, 'createPegawai'])->name('create.pegawai');
    Route::post('/edit-nama-pegawai/{id}', [PegawaiController::class, 'editPegawai'])->name('edit.pegawai');
    Route::post('/delete-nama-pegawai/{id}', [PegawaiController::class, 'deletePegawai'])->name('delete.pegawai');

    //area rayon
    Route::get('/area-rayon', [AreaRayonController::class, 'index'])->name('area_rayon');
    Route::post('/tambah-area-rayon', [AreaRayonController::class, 'tambahAreaRayon'])->name('tambah.area_rayon');
    Route::post('/edit-area-rayon/{id}', [AreaRayonController::class, 'editAreaRayon'])->name('edit.area_rayon');
    Route::post('/delete-area-rayon/{id}', [AreaRayonController::class, 'deleteAreaRayon'])->name('delete.area_rayon');

    //area sub rayon
    Route::get('/sub-rayon', [SubRayonController::class, 'index'])->name('sub_rayon');
    Route::post('/tambah-sub-rayon', [SubRayonController::class, 'tambahSubRayon'])->name('tambah.sub_rayon');
    Route::post('/edit-sub-rayon/{id}', [SubRayonController::class, 'editSubRayon'])->name('edit.sub_rayon');
    Route::post('/delete-sub-rayon/{id}', [SubRayonController::class, 'deleteSubRayon'])->name('delete.sub_rayon');

    //sales
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');
    Route::get('/sales-download-excel', function () {
        return view('excel.sales');
    });
    Route::get('/sales-download-pdf', [SalesController::class, 'export_sales_pdf'])->name('export_sales_pdf');
    Route::post('/tambah-sales', [SalesController::class, 'tambahSales'])->name('tambah.sales');
    Route::post('/edit-sales/{id}', [SalesController::class, 'editSales'])->name('edit.sales');
    Route::post('/delete-sales/{id}', [SalesController::class, 'deleteSales'])->name('delete.sales');

    //set akses
    Route::get('/set-akses', [SetAksesController::class, 'index'])->name('set_akses');
    Route::post('/tambah-set-akses', [SetAksesController::class, 'tambahSetAkses'])->name('tambah.set_akses');
    Route::post('/edit-set-akses/{id}', [SetAksesController::class, 'editSetAkses'])->name('edit.set_akses');
    Route::post('/delete-set-akses/{id}', [SetAksesController::class, 'deleteSetAkses'])->name('delete.set_akses');

    //set user
    Route::get('/set-user', [SetUserController::class, 'index'])->name('set_user');
    Route::post('/tambah-set-user', [SetUserController::class, 'tambahUser'])->name('tambah.set_user');
    Route::post('/edit-set-user/{id}', [SetUserController::class, 'editUser'])->name('edit.set_user');
    Route::post('/delete-set-user/{id}', [SetUserController::class, 'deleteUser'])->name('delete.set_user');

    //target spv
    Route::get('/target-spv', [TargetSPVController::class, 'index'])->name('target_spv');
    Route::get('/target-spv-download-excel/{id}', [TargetSPVController::class, 'excel_target_spv'])->name('excel_target_spv');
    Route::get('/target-spv-download-pdf/{id}', [TargetSPVController::class, 'export_target_spv_pdf'])->name('export_target_spv_pdf');
    Route::post('/tambah-target-spv', [TargetSPVController::class, 'tambahTargetSpv'])->name('tambah.target_spv');
    Route::post('/edit-target-spv/{id}', [TargetSPVController::class, 'editTargetSpv'])->name('edit.target_spv');
    Route::post('/delete-target-spv/{id}', [TargetSPVController::class, 'deleteTargetSpv'])->name('delete.target_spv');

    //target sales
    Route::get('/target-sales', [TargetSalesController::class, 'index'])->name('target_sales');
    Route::get('/target-sales-download-excel/{id}', [TargetSalesController::class, 'excel_target_sales'])->name('excel_target_sales');
    Route::get('/target-sales-download-pdf/{id}', [TargetSalesController::class, 'export_target_sales_pdf'])->name('export_target_sales_pdf');
    Route::post('/tambah-target-sales', [TargetSalesController::class, 'tambahTargetSales'])->name('tambah.target_sales');
    Route::post('/edit-target-sales/{id}', [TargetSalesController::class, 'editTargetSales'])->name('edit.target_sales');
    Route::post('/delete-target-sales/{id}', [TargetSalesController::class, 'deleteTargetSales'])->name('delete.target_sales');

    //target produk
    Route::get('/target-produk', [TargetProdukController::class, 'index'])->name('target_produk');
    Route::get('/target-produk-download-pdf/{id}', [TargetProdukController::class, 'export_target_produk_pdf'])->name('export_target_produk_pdf');
    Route::post('/tambah-target-produk', [TargetProdukController::class, 'tambahTargetProduk'])->name('tambah.target_produk');
    Route::post('/edit-target-produk', [TargetProdukController::class, 'editTargetProduk'])->name('edit.target_produk');
    Route::post('/delete-target-produk', [TargetProdukController::class, 'deleteTargetProduk'])->name('delete.target_produk');

    //master
    //obat dan barang
    Route::get('/obat-dan-barang', [ObatBarangController::class, 'index'])->name('obat-barang');
    Route::get('/produk-download-excel', [ObatBarangController::class, 'excel_produk'])->name('excel_produk');
    Route::get('/obat-dan-barang-download-pdf', [ObatBarangController::class, 'export_produk_pdf'])->name('export_produk_pdf');
    Route::post('/tambah-obat-dan-barang', [ObatBarangController::class, 'tambahObat'])->name('tambah.obat-barang');
    Route::post('/edit-obat-dan-barang/{id}', [ObatBarangController::class, 'editObat'])->name('edit.obat-barang');
    Route::post('/delete-obat-dan-barang/{id}', [ObatBarangController::class, 'deleteObat'])->name('delete.obat-barang');
    Route::get('/cari-produk-e-report', [ObatBarangController::class, 'ProdukEReport'])->name('e-report.obat-barang');
    Route::get('/tampil-produk-e-report', [ObatBarangController::class, 'cariProdukEReport'])->name('cari.e-report');
    Route::post('/obat-dan-barang/import', [ObatBarangController::class, 'import'])->name('import.obat-barang');


    Route::get('/set-harga-jual/{id}', [SetHargaJualController::class, 'index'])->name('setHarga');
    Route::post('/create-set-harga-jual', [SetHargaJualController::class, 'createHarga'])->name('create.setHarga');
    Route::post('/set-harga-jual', [SetHargaJualController::class, 'updateHarga'])->name('update.setHarga');

    //satuan
    Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan');
    Route::post('/tambah-satuan', [SatuanController::class, 'tambahSatuan'])->name('tambah.satuan');
    Route::post('/edit-satuan/{id}', [SatuanController::class, 'editSatuan'])->name('edit.satuan');
    Route::post('/delete-satuan/{id}', [SatuanController::class, 'deleteSatuan'])->name('delete.satuan');

    //golongan
    Route::get('/golongan', [GolonganController::class, 'index'])->name('golongan');
    Route::post('/tambah-golongan', [GolonganController::class, 'tambahGolongan'])->name('tambah.golongan');
    Route::post('/edit-golongan/{id}', [GolonganController::class, 'editGolongan'])->name('edit.golongan');
    Route::post('/delete-golongan/{id}', [GolonganController::class, 'deleteGolongan'])->name('delete.golongan');

    Route::get('/sub-golongan', [SubGolonganController::class, 'index'])->name('sub-golongan');
    Route::post('/tambah-sub-golongan', [SubGolonganController::class, 'tambahSubGolongan'])->name('tambah.sub-golongan');
    Route::post('/edit-sub-golongan/{id}', [SubGolonganController::class, 'editSubGolongan'])->name('edit.sub-golongan');
    Route::post('/delete-sub-golongan/{id}', [SubGolonganController::class, 'deleteSubGolongan'])->name('delete.sub-golongan');

    //jenis obat barang
    Route::get('/jenis-obat-barang', [JenisObatBarangController::class, 'index'])->name('jenis-obat');
    Route::post('/tambah-jenis-obat-barang', [JenisObatBarangController::class, 'tambahJenis'])->name('tambah.jenis-obat');
    Route::post('/edit-jenis-obat-barang/{id}', [JenisObatBarangController::class, 'editJenis'])->name('edit.jenis-obat');
    Route::post('/delete-jenis-obat-barang/{id}', [JenisObatBarangController::class, 'deleteJenis'])->name('delete.jenis-obat');

    Route::get('/nama-gudang', [GudangController::class, 'index'])->name('gudang');
    Route::post('/tambah-nama-gudang', [GudangController::class, 'tambahGudang'])->name('tambah.gudang');
    Route::post('/edit-nama-gudang/{id}', [GudangController::class, 'editGudang'])->name('edit.gudang');
    Route::post('/delete-nama-gudang/{id}', [GudangController::class, 'deleteGudang'])->name('delete.gudang');

    //rak
    Route::get('/rak', [RakController::class, 'index'])->name('rak');
    Route::post('/tambah-rak', [RakController::class, 'tambahRak'])->name('tambah.rak');
    Route::post('/edit-rak/{id}', [RakController::class, 'editRak'])->name('edit.rak');
    Route::post('/delete-rak/{id}', [RakController::class, 'deleteRak'])->name('delete.rak');

    //sub rak
    Route::get('/sub-rak', [SubRakController::class, 'index'])->name('sub-rak');
    Route::post('/tambah-sub-rak', [SubRakController::class, 'tambahSubRak'])->name('tambah.sub-rak');
    Route::post('/edit-sub-rak/{id}', [SubRakController::class, 'editSubRak'])->name('edit.sub-rak');
    Route::post('/delete-sub-rak/{id}', [SubRakController::class, 'deleteSubRak'])->name('delete.sub-rak');

    //customer
    //kelompok
    Route::get('/kelompok', [KelompokController::class, 'index'])->name('kelompok');
    Route::post('/tambah-kelompok', [KelompokController::class, 'tambahKelompok'])->name('tambah.kelompok');
    Route::post('/edit-kelompok/{id}', [KelompokController::class, 'editKelompok'])->name('edit.kelompok');
    Route::post('/delete-kelompok/{id}', [KelompokController::class, 'deleteKelompok'])->name('delete.kelompok');

    //pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
    Route::get('/pelanggan-download-excel', [PelangganController::class, 'excel_pelanggan'])->name('excel_pelanggan');
    Route::get('/pelanggan-download-pdf', [PelangganController::class, 'export_pelanggan_pdf'])->name('export_pelanggan_pdf');
    Route::post('/tambah-pelanggan', [PelangganController::class, 'tambahPelanggan'])->name('tambah.pelanggan');
    Route::post('/edit-pelanggan/{id}', [PelangganController::class, 'editPelanggan'])->name('edit.pelanggan');
    Route::post('/delete-pelanggan/{id}', [PelangganController::class, 'deletePelanggan'])->name('delete.pelanggan');
    Route::post('/import-pelanggan', [PelangganController::class, 'import'])->name('import.pelanggan');

    //produsen dan customer
    //produsen
    Route::get('/produsen', [ProdusenController::class, 'index'])->name('produsen');
    Route::post('/tambah-produsen', [ProdusenController::class, 'tambahProdusen'])->name('tambah.produsen');
    Route::post('/edit-produsen/{id}', [ProdusenController::class, 'editProdusen'])->name('edit.produsen');
    Route::post('/delete-produsen/{id}', [ProdusenController::class, 'deleteProdusen'])->name('delete.produsen');

    //suplier
    Route::get('/suplier', [SuplierController::class, 'index'])->name('suplier');
    Route::get('/suplier-download-excel', [SuplierController::class, 'excel_suplier'])->name('excel_suplier');
    Route::get('/suplier-download-pdf', [SuplierController::class, 'export_suplier_pdf'])->name('export_suplier_pdf');
    Route::post('/tambah-suplier', [SuplierController::class, 'tambahSuplier'])->name('tambah.suplier');
    Route::post('/edit-suplier/{id}', [SuplierController::class, 'editSuplier'])->name('edit.suplier');
    Route::post('/delete-suplier/{id}', [SuplierController::class, 'deleteSuplier'])->name('delete.suplier');
    Route::post('/import-supplier', [SuplierController::class, 'import'])->name('import.supplier');

    Route::get('/ekspedisi', [EkspedisiController::class, 'index'])->name('ekspedisi');

    //set awal
    //stok awal
    Route::get('/stok-awal', [StokAwalController::class, 'index'])->name('stok-awal');
    Route::get('/stok-awal-download-excel', [StokAwalController::class, 'excel_stok_awal'])->name('excel_stok_awal');
    Route::get('/stok-awal-download-pdf', [StokAwalController::class, 'export_stokawal_pdf'])->name('export_stokawal_pdf');
    Route::get('/get-nama-barang/{id}', [StokAwalController::class, 'getNamaBarang'])->name('get-barang');
    Route::post('/tambah-stok-awal', [StokAwalController::class, 'tambahStok'])->name('tambah.stok-awal');
    Route::post('/edit-stok-awal/{id}', [StokAwalController::class, 'editStok'])->name('edit.stok-awal');
    Route::post('/delete-stok-awal/{id}', [StokAwalController::class, 'deleteStok'])->name('delete.stok-awal');
    Route::get('/get-isi-barang/{id}/{satuan}', [StokAwalController::class, 'getIsiBarang'])->name('getIsiBarang');
    Route::post('/import-stok-awal', [StokAwalController::class, 'import'])->name('import.stok-awal');


    //set awal
    Route::get('/hutang-awal', [HutangAwalController::class, 'index'])->name("hutang-awal");
    Route::get('/hutang-awal-download-excel', [HutangAwalController::class, 'excel_hutang_awal'])->name('excel_hutang_awal');
    Route::get('/hutang-awal-download-pdf', [HutangAwalController::class, 'export_hutangawal_pdf'])->name('export_hutangawal_pdf');
    Route::post('/tambah-hutang-awal', [HutangAwalController::class, 'create'])->name('tambah.hutang-awal');
    Route::post('/edit-hutang-awal/{id}', [HutangAwalController::class, 'edit'])->name('edit.hutang-awal');
    Route::post('/hapus-hutang-awal/{id}', [HutangAwalController::class, 'destroy'])->name('delete.hutang-awal');
    Route::post('/import-hutang-awal', [HutangAwalController::class, 'import'])->name('import.hutang-awal');

    //piutang awal
    Route::get('/piutang-awal', [PiutangAwalController::class, 'index'])->name('piutang-awal');
    Route::get('/piutang-download-excel', [PiutangAwalController::class, 'excel_piutang'])->name('excel_piutang');
    Route::get('/piutang-awal-download-pdf', [PiutangAwalController::class, 'export_piutangawal_pdf'])->name('export_piutangawal_pdf');
    Route::post('/tambah-piutang-awal', [PiutangAwalController::class, 'create'])->name('tambah.piutang-awal');
    Route::post('/edit-piutang-awal/{id}', [PiutangAwalController::class, 'edit'])->name('edit.piutang-awal');
    Route::post('/hapus-piutang-awal/{id}', [PiutangAwalController::class, 'destroy'])->name('delete.piutang-awal');
    Route::post('/hapus-import-awal', [PiutangAwalController::class, 'import'])->name('import.piutang-awal');

    //akun akutansi
    Route::get('/akun-akuntansi', [AkunAkutansiController::class, 'index'])->name('akun-akutansi');
    Route::post('/tambah-akun-akuntansi', [AkunAkutansiController::class, 'tambahAkun'])->name('tambah.akun-akutansi');
    Route::post('/edit-akun-akuntansi/{id}', [AkunAkutansiController::class, 'editAkun'])->name('edit.akun-akutansi');
    Route::post('/delete-akun-akuntansi/{id}', [AkunAkutansiController::class, 'deleteAkun'])->name('delete.akun-akutansi');

    //set awal
    Route::get('/setting-akuntansi', function () {
        return view('pages.master.akuntansi.setting-akuntansi', [
            'title' => 'master'
        ]);
    });

    //barcode
    Route::get('/barcode-produk', [BarcodeController::class, 'indexProduk'])->name('barcode.produk');
    Route::get('/barcode-pelanggan', [BarcodeController::class, 'indexPelanggan'])->name('barcode.pelanggan');
    Route::get('/download-barcode/{data}', [BarcodeController::class, 'download'])->name('download.barcode');

    // Saldo Awal
    Route::get('/saldo-awal', [SaldoAwalController::class, 'index'])->name('saldo-awal');
    Route::get('/saldo-awal-download-excel', [SaldoAwalController::class, 'excel_saldo_awal'])->name('excel_saldo_awal');
    Route::get('/saldo-awal-download-pdf', [SaldoAwalController::class, 'export_saldoawal_pdf'])->name('export_saldoawal_pdf');

    //neraca
    Route::get('/neraca', [NeracaController::class, 'index'])->name('neraca');
    Route::get('/neraca/print/{filter}', [NeracaController::class, 'print'])->name('neraca.print');

    Route::get('/filter-neraca', [NeracaController::class, 'filter']);
    // neraca lajur
    Route::get('/neraca-lajur', [NeracaLajurController::class, 'index']);

    //--->buku besar
    Route::get('/buku-besar', [BukuBesarController::class, 'index'])->name('buku.besar');
    Route::get('/cetak-buku-besar', [BukuBesarController::class, 'cetakBukuBesar'])->name('cetak.buku-besar');

    //pembelian
    Route::get('/tambah-pembelian', [TambahPembelianController::class, 'index'])->name('tambah-pembelian')->middleware(['permission:akses_pembelian']);
    Route::get('/edit-pembelian/{id}', [TambahPembelianController::class, 'editPembelian'])->name('edit-pembelian');
    Route::get('/lihat-pembelian/{id}', [TambahPembelianController::class, 'lihatPembelian'])->name('lihat-pembelian');

    Route::get('/pembuatan-sp', [PembuatanSPController::class, 'index'])->name('pembuatan-sp');
    Route::get('/pemesanan-suplier-download-pdf/{id_sp}', [PembuatanSPController::class, 'export_pemesanan_suplier_pdf'])->name('export_pemesanan_suplier_pdf');

    Route::get('/terima-barang', [TerimaBarangController::class, 'index']);
    Route::get('/tambah-terima-barang', [TerimaBarangController::class, 'tambahTerimaBarang']);
    Route::get('/edit-terima-barang/{id}', [TerimaBarangController::class, 'editTerimaBarang']);

    //persediaan
    Route::get('/histori-stok', [PersediaanController::class, 'historiStok'])->name('histori-stok');
    Route::get('/kartu-stok', [PersediaanController::class, 'kartuStok'])->name('kartu-stok');
    Route::get('/excel-cetak-kartu', [PersediaanController::class, 'excel_cetak_kartu'])->name('excel_cetak_kartu');
    Route::get('/cetak-kartu-stok-pdf', [PersediaanController::class, 'export_cetak_kartu_pdf'])->name('export_cetak_kartu_pdf');
    Route::get('/stok-opname', [PersediaanController::class, 'stokOpname']);
    Route::get('/stok-opname-download-excel', [PersediaanController::class, 'excel_stok_opname'])->name('excel_stok_opname');
    Route::get('/stok-opname-download-pdf', [PersediaanController::class, 'export_stok_opname_pdf'])->name('export_stok_opname_pdf');
    Route::get('/data-stok-opname-download-pdf', [PersediaanController::class, 'export_data_stok_opname_pdf'])->name('export_data_stok_opname_pdf');
    Route::get('/data-stok-opname-download-excel', [PersediaanController::class, 'excel_data_stok_opname'])->name('excel_data_stok_opname');
    Route::get('/tambah-stok-opname', [PersediaanController::class, 'tambahStokOpname']);
    Route::get('/mutasi-stok', [PersediaanController::class, 'mutasiStok']);
    Route::get('/mutasi-download-pdf', [PersediaanController::class, 'export_mutasi_stok_pdf'])->name('export_mutasi_stok_pdf');
    Route::get('/mutasi-download-excel', [PersediaanController::class, 'excel_mutasi_stok'])->name('excel_mutasi_stok');
    Route::get('/tambah-mutasi-stok', [PersediaanController::class, 'tambahMutasiStok']);

    //penjualan
    //sp penjualan
    Route::get('/sp-penjualan', [PenjualanController::class, 'spPenjualan']);
    Route::get('/tambah-sp-penjualan', [PenjualanController::class, 'tambahSPPenjualan']);
    Route::get('/exportCSV', [PenjualanController::class, 'exportCSV'])->name('csv-pajak-keluaran');
    Route::get('/cetak-sp-penjualan/{id}', [PenjualanController::class, 'cetakSPPenjualan'])->name('cetak-sp-penjualan');
    //cek pesanan penjualan
    Route::get('/cek-sp-penjualan', [PenjualanController::class, 'cekSPPenjualan']);
    Route::get('/edit-pesanan-penjualan/{id}', [PenjualanController::class, 'editPesananPenjualan']);
    Route::get('/print-sp-penjualan/{sPPenjualan}', [PenjualanController::class, 'printSP'])->name('printSP');
    //penjualan
    Route::get('/penjualan', [PenjualanController::class, 'penjualan']);
    Route::get('/{sale}/print-penjualan', [PenjualanController::class, 'printPenjualan'])->name('penjualan.print');
    Route::get('/tambah-penjualan', [PenjualanController::class, 'tambahPenjualan']);
    //retur penjualan
    Route::get('/retur-penjualan', [PenjualanController::class, 'returPenjualan']);
    Route::get('/tambah-retur-penjualan', [PenjualanController::class, 'tambahReturPenjualan']);
    Route::get('/cetak-retur-penjualan/{id}', [PenjualanController::class, 'cetakPerReturPenjualan']);
    //surat jalan
    Route::get('/surat-jalan', [PenjualanController::class, 'suratJalan']);
    Route::get('/tambah-surat-jalan', [PenjualanController::class, 'tambahSuratJalan']);
    Route::get('/edit-surat-jalan/{id}', [PenjualanController::class, 'editSuratJalan']);
    Route::get('/status-surat-jalan/{id}', [PenjualanController::class, 'statusSuratJalan']);
    Route::get('/cetak-surat-jalan/{id}', [PenjualanController::class, 'cetakSuratJalan']);

    Route::get('/setting-nomor-faktur', [PenjualanController::class, 'settingNoFaktur']);

    //transaksi
    //rencana pengadaan
    Route::get('/analisis-pareto-abc', [PengadaanController::class, 'analisisPareto']);
    Route::get('/analisis-pareto-download-excel', [PengadaanController::class, 'excel_analisis_pareto'])->name('excel_analisis_pareto');
    Route::get('/analisis-pareto-download-pdf', [PengadaanController::class, 'export_analisis_pareto_pdf'])->name('export_analisis_pareto_pdf');
    Route::get('/analisis-order', [PengadaanController::class, 'analisisOrder']);
    Route::get('/analisis-order-download-excel', [PengadaanController::class, 'excel_analisis_order'])->name('excel_analisis_order');
    Route::get('/analisis-order-download-pdf', [PengadaanController::class, 'export_analisis_order_pdf'])->name('export_analisis_order_pdf');
    Route::get('/defecta', [PengadaanController::class, 'defecta']);
    Route::get('/histori-pembelian/{id}', [PengadaanController::class, 'historiPembelian']);
    Route::get('/cek-rencana-order', [PengadaanController::class, 'cekRencanaOrder']);

    //cetak transaksi
    Route::get('/cetak-pembelian-pdf/{id}', [CetakTransaksiController::class, 'cetakPembelian'])->name('cetak-pembelian-pdf');
    Route::get('/cetak-terima-barang-pdf/{id}', [CetakTransaksiController::class, 'cetakTerimaBarang'])->name('cetak-terima-barang');
    Route::get('/cetak-retur-pembelian-pdf/{id}', [CetakTransaksiController::class, 'cetakReturPembelian'])->name('cetak-retur-pembelian');

    //keuangan dan akuntansi
    //->keuangan
    //-->kontrabon
    Route::get('/kontrabon', [KeuanganController::class, 'kontrabon']);
    Route::get('/tambah-kontrabon', [KeuanganController::class, 'tambahKontrabon']);
    Route::get('/edit-kontrabon/{id}', [KeuanganController::class, 'editKontrabon']);
    Route::get('/cetak-kontrabon/{id}', [KeuanganController::class, 'cetakKontrabon']);
    //-->tagihan pelanggan
    Route::get('/tagihan-pelanggan', [KeuanganController::class, 'tagihanPelanggan']);
    Route::get('/tambah-tagihan-pelanggan', [KeuanganController::class, 'tambahTagihanPelanggan']);
    Route::get('/edit-tagihan-pelanggan/{id}', [KeuanganController::class, 'editTagihanPelanggan']);
    Route::get('/cetak-tagihan-pelanggan/{id}', [KeuanganController::class, 'cetakTagihan']);
    //--->pembayaran hutang
    Route::get('/pembayaran-hutang', [KeuanganController::class, 'pembayaranHutang']);
    Route::get('/tambah-pembayaran-hutang', [KeuanganController::class, 'tambahPembayaranHutang']);
    Route::get('/lihat-pembayaran-hutang/{id}', [KeuanganController::class, 'lihatPembayaranHutang']);
    Route::get('/cetak-nota-pembayaran-hutang/{id}', [KeuanganController::class, 'cetakNotaHutang']);
    //--pembayaran piutang
    Route::get('/pembayaran-piutang', [KeuanganController::class, 'pembayaranPiutang']);
    Route::get('/tambah-pembayaran-piutang', [KeuanganController::class, 'tambahPembayaranPiutang']);
    Route::get('/edit-pembayaran-piutang/{id}', [KeuanganController::class, 'editPembayaranPiutang']);
    Route::get('/cetak-pembayaran-piutang/{id}', [KeuanganController::class, 'cetakPembayaranPiutang']);
    //--->mutasi saldo
    Route::get('/mutasi-saldo', [KeuanganController::class, 'mutasiSaldo']);
    Route::get('/cetak-mutasi-saldo/{id}', [KeuanganController::class, 'cetakMutasiSaldo']);
    //--->jurnal akun
    Route::get('/jurnal-akun', [KeuanganController::class, 'jurnalAkun']);
    Route::get('/tambah-jurnal-akun', [KeuanganController::class, 'tambahJurnalAKun']);
    Route::get('/cetak-jurnal-akun/{id}', [KeuanganController::class, 'cetakJurnalAkun']);

    //->utilities
    //-->pajak
    //--->pajak masukan
    // Route::get('/pajak-masukan', [PriceListController::class, 'pajakMasukan']);
    // //---> retur pajak masukan
    // Route::get('/retur-pajak-masukan', [LaporanPajakController::class, 'returPajakMasukan']);
    // //---> pajak keluaran
    // Route::get('/pajak-keluaran', [LaporanPajakController::class, 'pajakKeluaran']);
    // //---> retur pajak keluaran
    // Route::get('/retur-pajak-keluaran', [LaporanPajakController::class, 'returPajakKeluaran']);
    Route::get('/pajak-masukan', [LaporanPajakController::class, 'pajakMasukan']);
    //---> retur pajak masukan

    Route::get('/retur-pajak-masukan', [LaporanPajakController::class, 'returPajakMasukan']);
    //---> pajak keluaran
    Route::get('/pajak-keluaran', [LaporanPajakController::class, 'pajakKeluaran']);
    //---> retur pajak keluaran
    Route::get('/retur-pajak-keluaran', [LaporanPajakController::class, 'returPajakKeluaran']);

    //reset database
    Route::get('/reset-database', [DatabaseController::class, 'reset']);

    //route Utilities

    //PRODUK
    Route::get('/price-list-produk', [PriceListController::class, 'index'])->name('price')->middleware('permission:akses_laporan_produk');
    Route::get('/price-list-produk/cetak_pdf', [PriceListController::class, 'cetak_pdf'])->name('cetak_pdf')->middleware('permission:akses_laporan_produk');;
    Route::get('/price-list-produk/cetak_excel', [PriceListController::class, 'cetak_excel'])->name('cetak_excel')->middleware('permission:akses_laporan_produk');;

    Route::get('/price-list-produk', [PriceListController::class, 'index'])->middleware(['permission:akses_laporan_produk'])->middleware('permission:akses_laporan_produk');
    // Route::get('/price-list-produk/cetak_pdf', [PriceListController::class, 'cetak_pdf']);

    Route::get('/exp-produk', [ExpProdukController::class, 'index'])->middleware('permission:akses_laporan_produk');
    Route::get('/exp-produk/cetak_pdf', [ExpProdukController::class, 'cetak_pdf'])->name('cetak_pdf_exp')->middleware('permission:akses_laporan_produk');

    Route::get('/nilai-persediaan', [NilaiPersediaanController::class, 'index'])->middleware('permission:akses_laporan_produk');
    Route::get('/nilai-persediaan/cetak_pdf', [NilaiPersediaanController::class, 'cetak_pdf'])->name('cetak_pdf_nilai')->middleware('permission:akses_laporan_produk');

    ///PENJUALAN
    Route::get('/rekap-penjualan', [RekapPenjualanController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/rekap-penjualan/cetak_pdf', [RekapPenjualanController::class, 'cetak_pdf'])->name('cetak_pdf_rekap')->middleware('permission:akses_laporan_penjualan');

    Route::get('/penjualan-per-pelanggan', [PenjualanPerPelangganController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/penjualan-per-pelanggan/cetak_pdf', [PenjualanPerPelangganController::class, 'cetak_pdf'])->name('cetak_pdf_pelanggan')->middleware('permission:akses_laporan_penjualan');

    Route::get('/penjualan-per-faktur', [PenjualanPerFakturController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/penjualan-per-faktur/cetak_pdf', [PenjualanPerFakturController::class, 'cetak_pdf'])->name('cetak_pdf_faktur')->middleware('permission:akses_laporan_penjualan');


    Route::get('/detail-penjualan-faktur', [DetailPenjualanFakturController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/detail-penjualan-faktur/cetak_pdf', [DetailPenjualanFakturController::class, 'cetak_pdf'])->name('cetak_pdf_faktur_detail')->middleware('permission:akses_laporan_penjualan');


    Route::get('/penjualan-per-produk', [PenjualanPerProdukController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/penjualan-per-produk/cetak_pdf', [PenjualanPerProdukController::class, 'cetak_pdf'])->name('cetak_pdf_produk')->middleware('permission:akses_laporan_penjualan');


    Route::get('/laba-penjualan-produk', [LabaPenjualanProdukController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/laba-penjualan-produk/cetak_pdf', [LabaPenjualanProdukController::class, 'cetak_pdf'])->name('cetak_pdf_laba_produk')->middleware('permission:akses_laporan_penjualan');

    Route::get('/detail-laba-faktur', [DetailLabaFakturController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/detail-laba-faktur/cetak_pdf', [DetailLabaFakturController::class, 'cetak_pdf'])->name('cetak_pdf_laba_faktur')->middleware('permission:akses_laporan_penjualan');

    Route::get('/retur-penjualans', [ReturPenjualanController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/retur-penjualans/cetak_pdf', [ReturPenjualanController::class, 'cetak_pdf'])->name('cetak_pdf_retur')->middleware('permission:akses_laporan_penjualan');

    Route::get('/sp-penjualans', [SpPenjualansController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/sp-penjualans/cetak_pdf', [SpPenjualansController::class, 'cetak_pdf'])->name('cetak_pdf_sp')->middleware('permission:akses_laporan_penjualan');


    Route::get('/detail-sp-penjualan', [DetailSpPenjualanController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/detail-sp-penjualan/cetak_pdf', [DetailSpPenjualanController::class, 'cetak_pdf'])->name('cetak_pdf_detail_sp')->middleware('permission:akses_laporan_penjualan');


    Route::get('/sp-vs-penjualan', [SpVsPenjualanController::class, 'index'])->middleware('permission:akses_laporan_penjualan');
    Route::get('/sp-vs-penjualan/cetak_pdf', [SpVsPenjualanController::class, 'cetak_pdf'])->name('cetak_pdf_vs')->middleware('permission:akses_laporan_penjualan');

    ///PEMBELIAN
    Route::get('/estimasi-sp-pembelian', [EstimasiSpPembelianController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/estimasi-sp-pembelian/cetak_pdf', [EstimasiSpPembelianController::class, 'cetak_pdf'])->name('cetak_pdf_estimasi')->middleware('permission:akses_laporan_pembelian');

    Route::get('/sp-pembelian', [SpPembelianController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/sp-pembelian/cetak_pdf', [SpPembelianController::class, 'cetak_pdf'])->name('cetak_pdf_sp_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/sp-pembelian-vs-pembelian', [SpPembelianVsPembelianController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/sp-pembelian-vs-pembelian/cetak_pdf', [SpPembelianVsPembelianController::class, 'cetak_pdf'])->name('cetak_pdf_vs_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/pembelian-per-faktur', [PembelianPerFakturController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/pembelian-per-faktur/cetak_pdf', [PembelianPerFakturController::class, 'cetak_pdf'])->name('cetak_pdf_faktur_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/pembelian-per-produk', [PembelianPerProdukController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/pembelian-per-produk/cetak_pdf', [PembelianPerProdukController::class, 'cetak_pdf'])->name('cetak_pdf_produk_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/pembelian-per-supplier', [PembelianPerSupplierController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/pembelian-per-supplier/cetak_pdf', [PembelianPerSupplierController::class, 'cetak_pdf'])->name('cetak_pdf_suplier_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/detail-pembelian-per-faktur', [DetailPembelianFakturController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/detail-pembelian-per-faktur/cetak_pdf', [DetailPembelianFakturController::class, 'cetak_pdf'])->name('cetak_pdf_detail_beli')->middleware('permission:akses_laporan_pembelian');

    Route::get('/detail-terima-barang', [DetailTerimaBarangController::class, 'index'])->middleware('permission:akses_laporan_pembelian');
    Route::get('/detail-terima-barang/cetak_pdf', [DetailTerimaBarangController::class, 'cetak_pdf'])->name('cetak_pdf_terima_detail')->middleware('permission:akses_laporan_pembelian');

    // ///HUTANG
    Route::get('/rekap-hutang', [RekapHutangController::class, 'index'])->middleware('permission:akses_laporan_hutang');
    Route::get('/rekap-hutang/cetak_pdf', [RekapHutangController::class, 'cetak_pdf'])->name('cetak_pdf_rekap_hutang')->middleware('permission:akses_laporan_hutang');

    Route::get('/kartu-hutang', [KartuHutangController::class, 'index'])->middleware('permission:akses_laporan_hutang');
    Route::get('/kartu-hutang/cetak_pdf', [KartuHutangController::class, 'cetak_pdf'])->name('cetak_pdf_kartu_hutang')->middleware('permission:akses_laporan_hutang');

    Route::get('/laporan-pembayaran-hutang', [PembayaranHutangController::class, 'index'])->middleware('permission:akses_laporan_hutang');
    Route::get('/pembayaran-hutang/cetak_pdf', [PembayaranHutangController::class, 'cetak_pdf'])->name('cetak_pdf_bayar_hutang')->middleware('permission:akses_laporan_hutang');

    Route::get('/hutang-jatuh-tempo', [HutangJatuhTempoController::class, 'index'])->middleware('permission:akses_laporan_hutang');
    Route::get('/hutang-jatuh-tempo/cetak_pdf', [HutangJatuhTempoController::class, 'cetak_pdf'])->name('cetak_pdf_tempo_hutang')->middleware('permission:akses_laporan_hutang');

    // ///PIUTANG
    Route::get('/rekap-piutang', [RekapPiutangController::class, 'index'])->middleware('permission:akses_laporan_piutang');
    Route::get('/rekap-piutang/cetak_pdf', [RekapPiutangController::class, 'cetak_pdf'])->name('cetak_pdf_rekap_piutang')->middleware('permission:akses_laporan_piutang');

    Route::get('/kartu-piutang', [KartuPiutangController::class, 'index'])->middleware('permission:akses_laporan_piutang');
    Route::get('/kartu-piutang/cetak_pdf', [KartuPiutangController::class, 'cetak_pdf'])->name('cetak_pdf_kartu_piutang')->middleware('permission:akses_laporan_piutang');

    Route::get('/laporan-pembayaran-piutang', [PembayaranPiutangController::class, 'index'])->middleware('permission:akses_laporan_piutang');
    Route::get('/pembayaran-piutang/cetak_pdf', [PembayaranPiutangController::class, 'cetak_pdf'])->name('cetak_pdf_bayar_piutang')->middleware('permission:akses_laporan_piutang');

    Route::get('/piutang-jatuh-tempo', [PiutangJatuhTempoController::class, 'index'])->middleware('permission:akses_laporan_piutang');
    Route::get('/piutang-jatuh-tempo/cetak_pdf', [PiutangJatuhTempoController::class, 'cetak_pdf'])->name('cetak_pdf_tempo_piutang')->middleware('permission:akses_laporan_piutang');

    Route::get('/kartu-hutang/print', [KartuHutangController::class, 'print'])->name('print_kartu_hutang')->middleware('permission:akses_laporan_piutang');
    Route::get('/kartu-piutang/print', [KartuPiutangController::class, 'print'])->name('print_kartu_piutang')->middleware('permission:akses_laporan_piutang');

    ///KEUANGAN
    Route::get('/kas-bank', [KasBankController::class, 'index'])->middleware('permission:akses_laporan_piutang')->middleware('permission:akses_keuangan');
    Route::get('/kas-bank/cetak_pdf', [KasBankController::class, 'cetak_pdf'])->name('cetak_pdf_kas_bank')->middleware('permission:akses_keuangan');


    ///PBF
    Route::get('/report-pbf', [ReportPBFController::class, 'index'])->middleware('permission:akses_pbf');
    Route::get('/report-pbf/cetak_pdf', [ReportPBFController::class, 'cetak_pdf'])->name('cetak_pdf_report')->middleware('permission:akses_pbf');


    Route::get('/was-distribusi', [WasDistribusiController::class, 'index'])->middleware('permission:akses_pbf');
    Route::get('/was-distribusi/cetak_pdf', [WasDistribusiController::class, 'cetak_pdf'])->name('cetak_pdf_was_distribusi')->middleware('permission:akses_pbf');
    Route::get('/export-excel', [WasDistribusiController::class, 'exportExcel'])->name('exportExcel')->middleware('permission:akses_pbf');


    Route::get('/was-penerimaan', [WasPenerimaanController::class, 'index'])->middleware('permission:akses_pbf');
    Route::get('/was-penerimaan/cetak_pdf', [WasPenerimaanController::class, 'cetak_pdf'])->name('penerimaan')->middleware('permission:akses_pbf');

    // });
    Route::get('/retur-penjualans', [ReturPenjualanController::class, 'index']);

    Route::get('/export_pemesanan_suplier_pdf-sp-penjualan', [SpPenjualansController::class, 'index']);

    Route::get('/detail-sp-penjualan', [DetailSpPenjualanController::class, 'index']);
    Route::get('/sp-vs-penjualan', [SpVsPenjualanController::class, 'index']);

    ///PEMBELIAN
    Route::get('/estimasi-sp-pembelian', [EstimasiSpPembelianController::class, 'index']);
    Route::get('/sp-pembelian', [SpPembelianController::class, 'index']);
    Route::get('/sp-pembelian-vs-pembelian', [SpPembelianVsPembelianController::class, 'index']);
    Route::get('/pembelian-per-faktur', [PembelianPerFakturController::class, 'index']);
    Route::get('/pembelian-per-produk', [PembelianPerProdukController::class, 'index']);
    Route::get('/pembelian-per-supplier', [PembelianPerSupplierController::class, 'index']);
    Route::get('/detail-pembelian-per-faktur', [DetailPembelianFakturController::class, 'index']);
    Route::get('/detail-terima-barang', [DetailTerimaBarangController::class, 'index']);


    ///HUTANG
    Route::get('/rekap-hutang', [RekapHutangController::class, 'index'])->middleware(['permission:akses laporan hutang']);;
    Route::get('/kartu-hutang', [KartuHutangController::class, 'index']);
    Route::get('/laporan-pembayaran-hutang', [PembayaranHutangController::class, 'index']);
    Route::get('/hutang-jatuh-tempo', [HutangJatuhTempoController::class, 'index']);

    ///PIUTANG
    Route::get('/rekap-piutang', [RekapPiutangController::class, 'index'])->middleware(['permission:akses laporan piutang']);;
    Route::get('/kartu-piutang', [KartuPiutangController::class, 'index']);
    Route::get('/Pembayaran-piutang', [PembayaranPiutangController::class, 'index']);
    Route::get('/piutang-jatuh-tempo', [PiutangJatuhTempoController::class, 'index']);

    Route::get('/tambah-saldo-awal', function () {
        return view('pages.set-awal.saldo-awal.tambah-saldo-awal', [
            'title' => 'setting awal'
        ]);
    });


    //pembelian
    Route::get('/pembelian', [PembelianController::class, 'pembelian']);
    Route::get('/retur-pembelian', [PembelianController::class, 'returPembelian']);
    Route::get('/tambah-retur-pembelian', [PembelianController::class, 'tambahReturPembelian']);

    //-->akuntansi
    //--->jurnal umum
    Route::get('/jurnal-umum', [AkutansiController::class, 'jurnalUmum']);
    Route::get('/cetak-jurnal-umum', [AkutansiController::class, 'cetakJurnalUmum'])->name('cetak-jurnal-umum');

    //--->laba/rugi
    Route::get('/laba-rugi', [AkutansiController::class, 'labaRugi']);
    Route::get('/laba-rugi/print/{filter}', [AkutansiController::class, 'labaRugiPrint'])->name('laba-rugi.print');

    //add backup feature
    Route::get('/backup', [BackupController::class, 'createBackup'])->name('backup.create');

    Route::get('/password-manager', [PasswordManagerController::class, 'index'])->name('password-manager');

    Route::get('/reset-password-harga', [PasswordManagerController::class, 'resetPassword'])->name('password-manager.reset');
});
