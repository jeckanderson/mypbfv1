<?php

namespace App\Imports;

use App\Models\AkunAkutansi;
use App\Models\DiskonKelompok;
use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Rak;
use App\Models\Satuan;
use App\Models\SetHarga;
use App\Models\StokAwal;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithValidation;

class StokAwalImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        try {
            $idPerusahaan = Auth::user()->id_perusahaan;

            // Mendapatkan produk berdasarkan barcode
            $produk = ObatBarang::where('barcode_produk', $row['barcode_produk'])->first();
            if (!$produk) {
                throw new \Exception('Produk dengan barcode tersebut tidak ditemukan.');
            }

            // Mendapatkan gudang berdasarkan nama gudang
            $gudang = Gudang::where('gudang', $row['gudang'])
                ->where('id_perusahaan', $idPerusahaan)
                ->first();
            if (!$gudang) {
                throw new \Exception('Gudang dengan nama tersebut tidak ditemukan.');
            }

            // Mendapatkan rak berdasarkan nama rak
            $rak = Rak::where('rak', $row['rak'])
                ->where('id_perusahaan', $idPerusahaan)
                ->first();
            if (!$rak) {
                throw new \Exception('Rak dengan nama tersebut tidak ditemukan.');
            }

            // Mendapatkan sub rak berdasarkan nama sub rak
            $subRak = SubRak::where('sub_rak', $row['sub_rak'])
                ->where('id_perusahaan', $idPerusahaan)
                ->first();
            if (!$subRak) {
                throw new \Exception('Sub Rak dengan nama tersebut tidak ditemukan.');
            }

            // Membuat model StokAwal
            $stok = new StokAwal([
                'id_perusahaan' => $idPerusahaan,
                'no_reff' => $row['no_reff'],
                'no_batch' => $row['no_batch'],
                'id_obat_barang' => $produk->id,
                'satuan' => Satuan::where('satuan', $row['satuan'])
                    ->where('id_perusahaan', $idPerusahaan)
                    ->first()->id,
                'jumlah' => $row['jumlah'],
                'exp_date' => $row['exp_date'],
                'hpp' => $row['hpp'],
                'gudang' => $gudang->id,
                'rak' => $rak->id,
                'sub_rak' => $subRak->id,
                'tipe' => $row['tipe'],
            ]);

            $stok->save();

            if ($stok) {
                $stok_masuk = $produk->isi * $row['jumlah'];

                $history = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->where('id_produk', $produk->id)
                    ->where('id_gudang', $gudang->id)
                    ->where('id_rak', $rak->id)
                    ->where('id_sub_rak', $subRak->id);
                // Membuat history stok
                HistoryStok::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_produk' => $produk->id,
                    'no_reff' => $row['no_reff'],
                    'no_faktur' => '-',
                    'no_batch' => $row['no_batch'],
                    'exp_date' => $row['exp_date'] ?? '-',
                    'suplier_pelanggan' => '-',
                    'id_gudang' => $gudang->id,
                    'id_rak' => $rak->id,
                    'id_sub_rak' => $subRak->id,
                    'sumber_set_harga' => 'Stok Awal',
                    'id_set_harga' => $stok->id,
                    'stok_masuk' => $stok_masuk,
                    'stok_keluar' => 0,
                    'stok_akhir' => ($history->sum('stok_masuk') - $history->sum('stok_keluar') ?? 0) + $stok_masuk,
                    'keterangan' => 'Stok Awal'
                ]);

                // Menambahkan ke Jurnal akun Persediaan dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $row['no_reff'],
                    'kode_akun' => AkunAkutansi::find(3)->kode,
                    'id_sumber' => $stok->id,
                    'sumber' => 'Stok Awal',
                    'keterangan' => 'Stok Awal',
                    'debet' => (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah'])),
                ]);

                // Menambahkan ke jurnal tetap akun persediaan dagang dan konsi
                $jurnalTetap = JurnalTetap::where('id_akun', 3)
                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->first();
                if ($jurnalTetap) {
                    $jurnalTetap->update([
                        'saldo' => $jurnalTetap->saldo + (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah'])),
                    ]);
                } else {
                    JurnalTetap::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_akun' => 3,
                        'saldo' => (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah']))
                    ]);
                }

                // Menambahkan ke jurnal akun modal
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $row['no_reff'],
                    'kode_akun' => AkunAkutansi::find(8)->kode,
                    'id_sumber' => $stok->id,
                    'sumber' => 'Stok Awal',
                    'keterangan' => 'Stok Awal',
                    'kredit' => (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah'])),
                ]);

                // Menambahkan ke jurnal tetap akun modal
                $jurnalTetap = JurnalTetap::where('id_akun', 8)
                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->first();
                if ($jurnalTetap) {
                    $jurnalTetap->update([
                        'saldo' => $jurnalTetap->saldo + (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah'])),
                    ]);
                } else {
                    JurnalTetap::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_akun' => 8,
                        'saldo' => (str_replace('.', '', $row['hpp']) * str_replace('.', '', $row['jumlah']))
                    ]);
                }

                // Menambahkan set harga
                foreach (Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $kelompok) {
                    foreach (DiskonKelompok::where('id_kelompok', $kelompok->id)
                        ->where('satuan_dasar_beli', '!=', null)
                        ->where('id_obat_barang', $stok->id_obat_barang)
                        ->get() as $disc) {
                        $hpp_final = (str_replace('.', '', $stok->hpp) / $stok->produk->isi) * $disc->isi;
                        $persentase = $disc->persentase;
                        $disc_1 = $disc->disc_1;
                        $disc_2 = $disc->disc_2;
                        $hasil_laba = round($hpp_final * (1 + $persentase / 100));
                        $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                        $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                        SetHarga::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'id_set_harga' => $stok->id,
                            'sumber' => 'Stok Awal',
                            'id_produk' => $stok->id_obat_barang,
                            'id_kelompok' => $kelompok->id,
                            'id_set' => $disc->id_set_harga,
                            'id_jumlah' => 1,
                            'satuan' => $disc->satuan_dasar_beli,
                            'jumlah' => '-',
                            'sampai' => '-',
                            'isi' => $disc->isi,
                            'hpp_final' => $hpp_final,
                            'laba' => $persentase,
                            'hasil_laba' => $hasil_laba,
                            'disc_1' => $disc_1,
                            'disc_2' => $disc_2,
                            'harga_jual' => $harga_jual,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Error importing Stok Awal: ' . $e->getMessage(), [
                'row_data' => $row,
                'exception' => $e
            ]);
            return $e->getMessage();
        }
    }

    public function rules(): array
    {
        return [
            'barcode_produk' => 'required',
            'gudang' => 'required',
            'rak' => 'required',
            'sub_rak' => 'required',
            'no_reff' => 'required',
            'no_batch' => 'required',
            'satuan' => 'required',
            'jumlah' => 'required',
            'exp_date' => 'nullable',
            'hpp' => 'required',
            'tipe' => 'required',
        ];
    }
}
