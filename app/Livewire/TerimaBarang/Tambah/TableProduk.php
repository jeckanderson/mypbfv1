<?php

namespace App\Livewire\TerimaBarang\Tambah;

use App\Models\DiskonKelompok;
use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Pembelian;
use App\Models\PPN;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use App\Models\Rak;
use App\Models\SetHarga;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class TableProduk extends Component
{
    public $id_pembelian = [], $gudangs = [], $raks = [], $sub_rak = [], $id;
    public $diterima = [];

    #[On('sendToTable')]
    public function getIdProduk($id_pembelian)
    {
        $this->id_pembelian = $id_pembelian;
    }

    public function mount()
    {
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->sub_rak = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        if ($this->id) {
            $firstProdukDiterima = ProdukDiterima::where('id_terima_barang', $this->id)->first();
            if ($firstProdukDiterima) {
                $this->id_pembelian = $firstProdukDiterima->id_pembelian;

                foreach (ProdukDiterima::where('id_terima_barang', $this->id)->get() as $index => $prod) {
                    $this->diterima[$index] = [
                        'batch' => $prod['no_batch'],
                        'tgl_exp_date' => $prod['tgl_exp_date'],
                        'gudang' => $prod['gudang'],
                        'rak' => $prod['rak'],
                        'sub_rak' => $prod['sub_rak']
                    ];
                }
            }
        }
    }

    public function hapusProduk($id)
    {
        $deleted = ProdukDiterima::find($id);
        if ($deleted) {
            if ($deleted->id_histori != null) {
                HistoryStok::find($deleted->id_histori)->delete();
            }
            $deleted->delete();
        }
        $this->dispatch('refresh');
    }

    #[On('simpanProdukDiterima')]
    public function simpanProduk($id_terima, $id_pembelian, $isCreate)
    {
        try {
            $produkDiterima = ProdukDiterima::where('id_pembelian', $id_pembelian)->get();

            foreach ($produkDiterima as $key => $produk) {
                // Validate required fields
                $gudang = $this->diterima[$key]['gudang'] ?? null;
                $rak = $this->diterima[$key]['rak'] ?? null;
                $sub_rak = $this->diterima[$key]['sub_rak'] ?? null;
                $batch = $this->diterima[$key]['batch'] ?? null;

                if (empty($gudang) || empty($rak) || empty($sub_rak)) {
                    session()->flash('alert', 'Gudang, Rak, atau Sub Rak tidak boleh kosong.');
                    return redirect()->back();
                }

                $stok_masuk = ObatBarang::find($produk->id_produk)->isi * $produk->diterima;
                $pembelian = Pembelian::find($id_pembelian);

                if ($isCreate) {
                    $historiCreate = HistoryStok::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_produk' => $produk->id_produk,
                        'no_reff' => $pembelian->no_reff,
                        'no_faktur' => $pembelian->no_faktur,
                        'no_batch' => $this->diterima[$key]['batch'],
                        'exp_date' => $this->diterima[$key]['tgl_exp_date'] ?? '-',
                        'suplier_pelanggan' => $pembelian->suplier,
                        'id_gudang' => $gudang,
                        'id_rak' => $rak,
                        'id_sub_rak' => $sub_rak,
                        'sumber_set_harga' => 'Pembelian',
                        'id_set_harga' => $produk->id,
                        'stok_masuk' => $stok_masuk,
                        'stok_keluar' => 0,
                        'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
                            ->where('id_produk', $produk->id_produk)
                            ->where('id_gudang', $gudang)
                            ->where('id_rak', $rak)
                            ->where('id_sub_rak', $sub_rak)
                            ->latest()->first()->stok_akhir ?? 0) + $stok_masuk,
                        'keterangan' => 'Pembelian'
                    ]);

                    $produk->update([
                        'id_terima_barang' => $id_terima,
                        'id_histori' => $historiCreate->id,
                        'no_batch' => $this->diterima[$key]['batch'],
                        'tgl_exp_date' => $this->diterima[$key]['tgl_exp_date'] ?? '-',
                        'gudang' => $gudang,
                        'rak' => $rak,
                        'sub_rak' => $sub_rak,
                    ]);
                    $this->createOrUpdateSetHarga($produk, $pembelian, true);
                } else {
                    $historiEdit = HistoryStok::findOrFail($produk->id_histori);
                    $historiEdit->update([
                        'no_batch' => $this->diterima[$key]['batch'],
                        'exp_date' => $this->diterima[$key]['tgl_exp_date'] ?? '-',
                        'id_gudang' => $gudang,
                        'id_rak' => $rak,
                        'id_sub_rak' => $sub_rak,
                    ]);

                    $produk->update([
                        'no_batch' => $this->diterima[$key]['batch'],
                        'tgl_exp_date' => $this->diterima[$key]['tgl_exp_date'] ?? '-',
                        'gudang' => $gudang,
                        'rak' => $rak,
                        'sub_rak' => $sub_rak,
                    ]);

                    SetHarga::where('id_set_harga', $produk->id)->where('sumber', 'Pembelian')->delete();
                    $this->createOrUpdateSetHarga($produk, $pembelian, false);
                }
            }

            return redirect('terima-barang');
        } catch (\Exception $e) {
            Log::error('Failed to save product: ' . $e->getMessage());
            // Handle the error as needed, e.g., show a message to the user
        }
    }

    protected function createOrUpdateSetHarga($produk, $pembelian, $isCreate)
    {
        foreach (Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $kelompok) {
            foreach (
                DiskonKelompok::where('id_kelompok', $kelompok->id)
                    ->where('satuan_dasar_beli', '!=', null)
                    ->where('id_obat_barang', $produk->id_produk)
                    ->get() as $disc
            ) {

                $hppPembelian = $produk->diterimaToPembelian->harga;
                //hppsatuan
                $hppSatuan = round(($produk->diterimaToPembelian->total / $produk->diterimaToPembelian->qty_faktur) / $produk->diterimaToPembelian->order->produk->isi, 5);
                //mencari jumlah kesuluruhan isi
                $id_sp = $produk->id_sp;
                $totalIsi = 0;

                $total = 0;
                foreach (ProdukPembelian::where('id_sp', $id_sp)->get() as $get) {
                    $totalIsi += $get->order->produk->isi * $get->qty_faktur;
                    $total += $get->total;
                }


                $disc_penjualan = $produk->diterimaToPembelian->pembelian->diskon;
                $hasil = $total * ($disc_penjualan / 100);
                // $hasil = 738.7875

                $pengurang = $hasil / $totalIsi;
                // $hasil_perhitungan = 1.477575

                // $pengurang = round($pembelian->hasil_diskon / $totalIsi, 5);
                $hppFinalPembelian = ($hppSatuan - $pengurang) * $disc->isi;
                if (intval($produk->diterimaToPembelian->pembelian->inc_ppn) == 1) {
                    $hppFinalPembelian = round($hppFinalPembelian / (1 + (PPN::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->ppn / 100)), 5);
                }
                $persentase = $disc->persentase;
                $disc_1 = $disc->disc_1;
                $disc_2 = $disc->disc_2;
                $hasil_laba = round($hppFinalPembelian * (1 + $persentase / 100));
                $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                SetHarga::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_set_harga' => $produk->id,
                    'sumber' => 'Pembelian',
                    'id_produk' => $produk->id_produk,
                    'id_kelompok' => $kelompok->id,
                    'id_set' => $disc->id_set_harga,
                    'id_jumlah' => 1,
                    'satuan' => $disc->satuan_dasar_beli,
                    'jumlah' => '-',
                    'sampai' => '-',
                    'isi' => $disc->isi,
                    'hpp_final' => $hppFinalPembelian,
                    'laba' => $persentase,
                    'hasil_laba' => $hasil_laba,
                    'disc_1' => $disc_1,
                    'disc_2' => $disc_2,
                    'harga_jual' => $harga_jual,
                ]);
            }
        }
    }


    public function render()
    {
        return view('livewire.terima-barang.tambah.table-produk', [
            'produks' => ProdukDiterima::where('id_pembelian', $this->id_pembelian)->get()
        ]);
    }
}