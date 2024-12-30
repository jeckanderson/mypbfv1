<?php

namespace App\Imports;

use App\Models\DiskonKelompok;
use App\Models\Golongan;
use App\Models\JenisObatBarang;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Produsen;
use App\Models\Satuan;
use App\Models\SubGolongan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ObatBarangImport implements ToModel, WithHeadingRow, WithChunkReading
{
    public function __construct(protected $id) {
        $this->id = $id;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Pastikan bahwa kolom yang diperlukan tersedia
        try {
            if (empty($row['nama_obat_barang']) || empty($row['satuan_dasar_beli'])) {
                throw new \Exception('Nama obat dan satuan dasar beli tidak boleh kosong.');
            }

           
            // Mengakses nilai berdasarkan heading
            $satuanDasarBeli = $this->getOrCreateModel(Satuan::class, 'satuan', $row['satuan_dasar_beli']);
            $satuanJualTerkecil = $this->getOrCreateModel(Satuan::class, 'satuan', $row['satuan_jual_terkecil']);
            $golongan = $this->getOrCreateModel(Golongan::class, 'golongan', $row['kategori']);
            $sub_golongan = $this->getOrCreateModel(SubGolongan::class, 'sub_golongan', $row['golongan']);
            $jenis_obat_barang = $this->getOrCreateModel(JenisObatBarang::class, 'jenis', $row['jenis_obat_barang']);
            $produsen = $this->getOrCreateModel(Produsen::class, 'produsen', $row['produsen']);

            // Membuat record ObatBarang baru
            $obatBarang = ObatBarang::updateOrCreate([
                'id_perusahaan' => $this->id,
                'barcode_produk' => $row['barcode_produk']
            ],[
                'nama_obat_barang' => $row['nama_obat_barang'],
                'kode_obat_barang' => $row['kode_obat_barang'] ?? '-',
                'kode_obat_bpom' => $row['kode_obat_bpom'] ?? '-',
                'satuan_dasar_beli' => $satuanDasarBeli,
                'barcode_qr_produk' => $row['barcode_qr_produk'],
                'barcode_produk' => $row['barcode_produk'],
                'isi' => $row['isi'],
                'satuan_jual_terkecil' => $satuanJualTerkecil,
                'ket_satuan' => $row['ket_satuan'],
                'kemasan' => $row['kemasan'],
                'golongan' => $golongan,
                'sub_golongan' => $sub_golongan,
                'jenis_obat_barang' => $row['jenis_obat_barang'],
                'produsen' => $produsen,
                'tipe' => $row['tipe'],
                'stok_minimal' => $row['stok_minimal'],
                'stok_maksimal' => $row['stok_maksimal'],
                'komposisi' => $row['komposisi'],
                'zat_aktif' => $row['zat_aktif'],
                'bentuk_kekuatan' => $row['bentuk_kekuatan'],
                'no_ijin_edar' => $row['no_ijin_edar'],
                'exp_date' => strtolower($row['exp_date']) === 'on' ? 1 : 0,
                'status' => strtolower($row['status']) === 'on' ? 1 : 0,
                'id_perusahaan' => $this->id,
            ]);

            $obatBarang->save();

            $kelompoks = Kelompok::where('id_perusahaan', $this->id)->get();
            $first = true;
            $count = Kelompok::count();
            $array = range(1, $count);
            foreach ($array as $key) {
                foreach ($kelompoks as $kelompok) {
                    DiskonKelompok::create([
                        'id_obat_barang' => $obatBarang->id,
                        'id_kelompok' => $kelompok->id,
                        'id_set_harga' => $key,
                        'isi' => $first ? $row['isi'] : null,
                        'satuan_dasar_beli' => $first ? $satuanDasarBeli : null,
                        'persentase' =>  0,
                        'disc_1' =>  0,
                        'disc_2' =>  0,
                    ]);
                }
                $first = false;
            }
            Log::info($row['nama_obat_barang'] . " Uploaded");
            return $obatBarang;
        } catch (\Throwable $th) {
            Log::error("Kode barang ".$row['kode_obat_barang'] ." Gagal Karena :" .$th->getMessage());
            //throw $th;
        }
    }

    /**
     * Helper function 
     * 
     * @param string 
     * @param string 
     * @param string 
     * @return int 
     */
    private function getOrCreateModel($model, $column, $value)
    {
        // $existingRecord = $model::where($column, $value)->first();
        // if ($existingRecord) {
        //     return $existingRecord->id;
        // } else {
        //     $newRecord = $model::create([$column => $value]);
        //     return $newRecord->id;
        // }
        $existingRecord = $model::updateOrCreate([$column => $value,'id_perusahaan' => $this->id]);
        return $existingRecord->id;
    }
    function chunkSize(): int
    {
        return 1000;
    }
}
