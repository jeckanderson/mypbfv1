<?php

namespace App\Exports\Penjualan;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class ExportCSV implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $pelanggan;

    public function __construct($start, $end, $pelanggan)
    {
        $this->start = Carbon::parse($start);
        $this->end = Carbon::parse($end);
        $this->pelanggan = $pelanggan;
    }

    public function collection()
    {
        $data = collect();
        $data->push([
            'LT',
            'NPWP',
            'NAMA',
            'JALAN',
            'BLOK',
            'NOMOR',
            'RT',
            'RW',
            'KECAMATAN',
            'KELURAHAN',
            'KABUPATEN',
            'PROVINSI',
            'KODE_POS',
            'NOMOR_TELEPON',
            '',
            '',
            '',
            '',
            ''
        ]);
        $data->push([
            'OF',
            'KODE_OBJEK',
            'NAMA',
            'HARGA_SATUAN',
            'JUMLAH_BARANG',
            'HARGA_TOTAL',
            'DISKON',
            'DPP',
            'PPN',
            'TARIF_PPNBM',
            'PPNBM',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ]);
        $sales = Penjualan::with('produk_penjualan')->with('getPelanggan')->with('profile');
        if ($this->start <> '' and $this->end <> '') {
            $sales->whereBetween('tgl_faktur', [$this->start, $this->end]);
        }

        if ($this->pelanggan <> '') {
            $sales->where('pelanggan', $this->pelanggan);
        }
        $sales = $sales->get();
        foreach ($sales as $sale) {
            // Push main sales data
            $data->push([
                'FK',
                '01',
                '0',
                str_replace('.', '', $sale->no_seri_pajak),
                date('m', strtotime($sale->tgl_faktur)),
                date('Y', strtotime($sale->tgl_faktur)),
                date('d/m/Y', strtotime($sale->tgl_faktur)),
                $sale->getPelanggan->npwp,
                $sale->getPelanggan->nama,
                $sale->getPelanggan->alamat,
                $sale->dpp,
                $sale->ppn,
                '0', // ppnbm
                '', // id keterangan tambahan
                '0', // fg uang muka
                '0', // uang muka dpp
                '0', // uang muka ppn
                '0', // uang muka ppnbm
                '' // referensi
            ]);

            $data->push([
                'FAPR',
                $sale->profile->nama_perusahaan,
                $sale->profile->alamat,
                '', // jalan
                '', // blok
                '', // nomor
                '', // rt
                '', // rw
                '', // kecamatan
                '', // kelurahan
                $sale->profile->getKabupaten->name,
                $sale->profile->getProvinsi->name,
                '', // kode pos
                $sale->profile->no_telepon,
                '',
                '',
                '',
                '',
                ''
            ]);

            foreach ($sale->produk_penjualan as $produk) {
                $data->push([
                    'OF',
                    $produk->produk->barcode_produk,
                    $produk->produk->nama_obat_barang,
                    $produk->harga,
                    $produk->qty,
                    $produk->harga * $produk->qty,
                    $this->total_diskon2($produk->harga, $produk->qty, $produk->disc_1, $produk->disc_2), // diskon 3
                    $this->hitung_dpp($produk->harga, $produk->qty, $produk->disc_1, $produk->disc_2, $sale->diskon), // dpp
                    round(($produk->modal_produk * $produk->qty) * ($sale->profile->ppn->ppn / 100)), // ppn,
                    '', // tarif ppnbm
                    '', // ppnbm
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''

                ]);
            }
        }

        return $data;
    }


    private function hitung_diskon1($harga, $diskon_1)
    {
        $diskon = round($harga * ($diskon_1 / 100));
        return $diskon;
    }

    private function hitung_diskon2($harga, $diskon_1, $diskon_2)
    {
        $diskon1 = round($this->hitung_diskon1($harga, $diskon_1));
        $harga_baru_1 = $harga - $diskon1;
        $diskon2 = round($harga_baru_1 * ($diskon_2 / 100));
        return $diskon2;
    }

    private function total_diskon2($harga, $qty, $diskon_1, $diskon_2)
    {
        $diskon1 = round($this->hitung_diskon1($harga, $diskon_1));
        $harga_baru_1 = round($harga - $diskon1);
        $diskon2 = round($this->hitung_diskon2($harga, $diskon_1, $diskon_2));
        $harga_baru_2 = round($harga_baru_1 - $diskon2);

        $harga_awal = round($harga * $qty);
        $harga_setelah_diskon2 = round($harga_baru_2 * $qty);
        return round($harga_awal - $harga_setelah_diskon2);
    }


    private function hitung_dpp($harga, $qty, $diskon_1, $diskon_2, $diskon_3)
    {
        $diskon1 = round($this->hitung_diskon1($harga, $diskon_1));
        $harga_baru_1 = round($harga - $diskon1);
        $diskon2 = round($this->hitung_diskon2($harga, $diskon_1, $diskon_2));
        $harga_baru_2 = round($harga_baru_1 - $diskon2);

        $harga_setelah_diskon2 = round($harga_baru_2 * $qty);
        return $harga_setelah_diskon2;
    }





    public function headings(): array
    {
        return [
            'FK', 'KD_JENIS_TRANSAKSI', 'FG_PENGGANTI', 'NOMOR_FAKTUR', 'MASA_PAJAK', 'TAHUN_PAJAK', 'TANGGAL_FAKTUR', 'NPWP', 'NAMA', 'ALAMAT_LENGKAP', 'JUMLAH_DPP', 'JUMLAH_PPN', 'JUMLAH_PPNBM', 'ID_KETERANGAN_TAMBAHAN', 'FG_UANG_MUKA', 'UANG_MUKA_DPP', 'UANG_MUKA_PPN', 'UANG_MUKA_PPNBM', 'REFERENSI',
        ];
    }
}
