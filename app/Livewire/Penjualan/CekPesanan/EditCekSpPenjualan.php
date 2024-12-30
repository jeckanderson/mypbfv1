<?php

namespace App\Livewire\Penjualan\CekPesanan;

use App\Models\DiskonKelompok;
use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\ObatBarang;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\ProdukDiterima;
use App\Models\ProdukPenjualan;
use App\Models\Rak;
use App\Models\SPPenjualan;
use App\Models\StokAwal;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class EditCekSpPenjualan extends Component
{
    public $id, $produks = [], $listStok = [], $listPembelian = [], $id_pelanggan;
    public $listeners = ['lanjutkanProses' => 'lanjutkanProses'];
    //masuk form
    public $tgl_input, $no_reff, $tgl_sp, $pelanggan, $sales, $no_sp, $tipe_sp, $status_cek, $penyimpanan = [], $keterangan;

    public function render()
    {
        return view('livewire.penjualan.cek-pesanan.edit-cek-sp-penjualan');
    }

    public function mount()
    {
        $dataSP = SPPenjualan::find($this->id);
        $this->tgl_input = $dataSP->tgl_input;
        $this->no_reff = $dataSP->no_reff;
        $this->tgl_sp = $dataSP->tgl_sp;
        $this->pelanggan = Pelanggan::find($dataSP->pelanggan)->nama;
        $this->id_pelanggan = $dataSP->pelanggan;
        $this->sales = Pegawai::find($dataSP->sales)->nama_pegawai;
        $this->no_sp = $dataSP->no_sp;
        $this->tipe_sp = $dataSP->tipe_sp;
        $this->status_cek = $dataSP->status_cek;
        $this->keterangan = $dataSP->keterangan_cek_sp;

        $this->produks = ProdukPenjualan::where('id_sp_penjualan', $this->id)->get();

        $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
            ->where('keterangan', '!=', 'Penjualan')
            ->where('keterangan', '!=', 'Retur Pembelian')
            ->where('keterangan', '!=', 'Retur Penjualan')
            ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'no_batch', 'id_produk')
            ->get()
            ->pluck('max_id');
        $stok = HistoryStok::whereIn('id', $stokTerbaru)
            ->get();

        $this->listStok = $stok;
        // if ($this->produks->first()->batch) {
        foreach ($this->produks as $key => $prod) {
            $this->penyimpanan[$key]['id'] = $prod->id;
            $this->penyimpanan[$key]['id_produk'] = $prod->id_produk;
            $this->penyimpanan[$key]['sumber'] = $prod->sumber;
            $this->penyimpanan[$key]['id_sumber'] = $prod->id_sumber;
            $this->penyimpanan[$key]['no_batch'] = $prod->batch;
            $this->penyimpanan[$key]['stok'] = $prod->stok;
            $this->penyimpanan[$key]['exp_date'] = $prod->exp_date;
            $this->penyimpanan[$key]['gudang'] = Gudang::find($prod->gudang)->gudang ?? '-';
            $this->penyimpanan[$key]['id_gudang'] = $prod->gudang ?? '-';
            $this->penyimpanan[$key]['rak'] = Rak::find($prod->rak)->rak ?? '-';
            $this->penyimpanan[$key]['id_rak'] = $prod->rak ?? '-';
            $this->penyimpanan[$key]['sub_rak'] = SubRak::find($prod->sub_rak)->sub_rak ?? '-';
            $this->penyimpanan[$key]['id_sub_rak'] = $prod->sub_rak ?? '-';
            $this->penyimpanan[$key]['qty'] = $prod->qty;
        }

        // }
    }


    public function tambahProduk($id_produk)
    {
        $prod = ProdukPenjualan::find($id_produk);
        $simpan = ProdukPenjualan::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_sp_penjualan' => $prod->id_sp_penjualan,
            'id_user' => Auth::id(),
            'id_produk' => $prod->produk->id,
            'qty_sp' => $prod->qty_sp,
            'satuan' => $prod->satuan,
            'produk_tambahan' => 1
        ]);
        return redirect()->to('/edit-pesanan-penjualan/' . $this->id);
    }

    public function hapusProduk($id_produk)
    {
        $produk = ProdukPenjualan::find($id_produk);
        if ($produk->produk_tambahan == 1) {
            $produk->delete();
        }
        return redirect()->to('/edit-pesanan-penjualan/' . $this->id);
    }

    public function updateStorageData($key)
    {
        $selectedBatch = $this->penyimpanan[$key]['selectedBatch'];

        if ($selectedBatch) {
            $history = HistoryStok::find($selectedBatch);
            if (!$history) {
                $this->penyimpanan[$key]['id_produk'] = '';
                $this->penyimpanan[$key]['no_batch'] = '-';
                $this->penyimpanan[$key]['stok'] = 0;
                $this->penyimpanan[$key]['exp_date'] = '-';
                $this->penyimpanan[$key]['gudang'] = '-';
                $this->penyimpanan[$key]['id_gudang'] = '-';
                $this->penyimpanan[$key]['rak'] = '-';
                $this->penyimpanan[$key]['id_rak'] = '-';
                $this->penyimpanan[$key]['sub_rak'] = '-';
                $this->penyimpanan[$key]['stok_real'] = 0;
                $this->penyimpanan[$key]['terpesan'] = '-';
                $this->penyimpanan[$key]['sisa_stok'] = '-';
                $this->penyimpanan[$key]['id_sub_rak'] = '-';
                $this->penyimpanan[$key]['qty'] = 0;
            } else {
                $no_batch = $history->no_batch;
                $id_produk = $history->id_produk;
                $exp_date = $history->exp_date;
                $gudang = $history->id_gudang;
                $rak = $history->id_rak;
                $sub_rak = $history->id_sub_rak;
                $isiStok = DiskonKelompok::where('id_obat_barang', $this->produks[$key]->id_produk)->where('id_kelompok', Pelanggan::find($this->id_pelanggan)->kelompok)->where('satuan_dasar_beli', $this->produks[$key]->satuan)->first()->isi;

                $query = HistoryStok::where('id_produk', $id_produk)
                    ->where('no_batch', $no_batch)
                    ->where('id_gudang', $gudang)
                    ->where('id_rak', $rak)
                    ->where('id_sub_rak', $sub_rak);

                $stok_akhir = $query->sum('stok_masuk') - $query->sum('stok_keluar');
                $id_produk_penjualan = $this->penyimpanan[$key]['id'];

                $qty_sp = ProdukPenjualan::where('id_produk', $this->penyimpanan[$key]['id_produk'])->where('id', '<', $id_produk_penjualan)->whereNull('id_penjualan')->orderBy('id', 'desc')->first()->qty ?? 0;
                $stok_real = $history->sisaStokBatch($history->id_produk, $history->no_batch, $history->id_gudang, $history->id_rak, $history->id_sub_rak) / $isiStok;
                // $qty_sp = $this->produks[$key]->produk->prevSP() instanceof ProdukPenjualan ? $this->produks[$key]->produk->prevSP()->qty : 0;
                // $formatted_stok = number_format($stok_akhir / $isiStok, 2);
                $formatted_stok = number_format($stok_akhir / $isiStok, 2);
                $formatted_stok = rtrim($formatted_stok, '.00');
                $this->penyimpanan[$key]['id_produk'] = $id_produk;
                $this->penyimpanan[$key]['sumber'] = $history->keterangan;
                $this->penyimpanan[$key]['id_sumber'] = $selectedBatch;
                $this->penyimpanan[$key]['no_batch'] = $no_batch;
                $this->penyimpanan[$key]['stok'] = $stok_akhir / $history->produk->isi;
                $this->penyimpanan[$key]['stok_real'] = $stok_real;
                $this->penyimpanan[$key]['terpesan'] = $qty_sp ?? 0;
                $this->penyimpanan[$key]['sisa_stok'] = $stok_real - ($qty_sp ?? 0);
                $this->penyimpanan[$key]['exp_date'] = $exp_date ?? '-';
                $this->penyimpanan[$key]['gudang'] = Gudang::find($gudang)->gudang;
                $this->penyimpanan[$key]['id_gudang'] = $gudang;
                $this->penyimpanan[$key]['rak'] = Rak::find($rak)->rak;
                $this->penyimpanan[$key]['id_rak'] = $rak;
                $this->penyimpanan[$key]['sub_rak'] = SubRak::find($sub_rak)->sub_rak;
                $this->penyimpanan[$key]['id_sub_rak'] = $sub_rak;
            }
        }
    }

    #[On('tambahQty')]
    public function tambah($key)
    {
        if (isset($this->penyimpanan[$key]['qty'])) {
            $this->penyimpanan[$key]['qty']++;
        } else {
            $this->penyimpanan[$key]['qty'] = 1;
        }
    }

    #[On('insertPelanggan')]
    public function onGetPelanggan($pelanggan)
    {
        $DataPelanggan = Pelanggan::find($pelanggan);
        $this->pelanggan = $DataPelanggan->nama;
        $this->sales = $DataPelanggan->sales;
    }

    public function simpanCekSPPenjualan()
    {
        $cek = $this->cekQty();
        if (!empty($cek)) {
            $this->js("alert('Quantity melebihi permintaan')");
            return;
        }
        DB::beginTransaction();
        $penjualan = SPPenjualan::find($this->id)->update(['status_cek' => 1, 'keterangan_cek_sp' => $this->keterangan]);
        if ($penjualan) {
            $produkPenjualan = ProdukPenjualan::where('id_sp_penjualan', $this->id)->get();
            foreach ($this->penyimpanan as $key => $simpan) {
                if ($simpan['qty'] > $simpan['sisa_stok']) {
                    $this->dispatch('stok-tidak-cukup');
                    DB::rollBack();
                    return;
                    // $this->js("confirm('Terdapat stock yang tidak mencukupi')");
                    // DB::rollBack();
                    // return;
                }
                $produkPenjualan[$key]->update([
                    'sumber' => $simpan['sumber'] ?? '-',
                    'id_sumber' => $simpan['id_sumber'] ?? '-',
                    'batch' => $simpan['no_batch'],
                    'exp_date' => $simpan['exp_date'],
                    'stok' => $simpan['stok'],
                    'terpesan' => $simpan['terpesan'],
                    'gudang' => $simpan['id_gudang'],
                    'rak' => $simpan['id_rak'],
                    'sub_rak' => $simpan['id_sub_rak'],
                    'qty' => $simpan['qty'],
                ]);
                DB::commit();
            }
            return redirect('/cek-sp-penjualan');
        }
    }
    public function lanjutkanProses()
    {
        DB::beginTransaction();
        $penjualan = SPPenjualan::find($this->id)->update(['status_cek' => 1, 'keterangan_cek_sp' => $this->keterangan]);
        if ($penjualan) {
            $produkPenjualan = ProdukPenjualan::where('id_sp_penjualan', $this->id)->get();
            foreach ($this->penyimpanan as $key => $simpan) {
                $produkPenjualan[$key]->update([
                    'sumber' => $simpan['sumber'] ?? '-',
                    'id_sumber' => $simpan['id_sumber'] ?? '-',
                    'batch' => $simpan['no_batch'],
                    'exp_date' => $simpan['exp_date'],
                    'stok' => $simpan['stok'],
                    'terpesan' => $simpan['terpesan'],
                    'gudang' => $simpan['id_gudang'],
                    'rak' => $simpan['id_rak'],
                    'sub_rak' => $simpan['id_sub_rak'],
                    'qty' => $simpan['qty'],
                ]);
            }
            DB::commit();
            return redirect('/cek-sp-penjualan');
        }
    }
    public function cekQty()
    {
        $uniqueProduks = [];
        foreach ($this->produks as $produk) {
            if (!isset($uniqueProduks[$produk['id_produk']])) {
                $uniqueProduks[$produk['id_produk']] = $produk;
            }
        }

        $totalQty = [];
        foreach ($this->penyimpanan as $item) {
            $kode = $item['id_produk'];
            if (!isset($totalQty[$kode])) {
                $totalQty[$kode] = 0;
            }
            $totalQty[$kode] += $item['qty'];
        }

        $errors = [];
        foreach ($totalQty as $kode => $qty) {
            if (isset($uniqueProduks[$kode]) && $qty > $uniqueProduks[$kode]['qty_sp']) {
                $errors[] = "Error: Kode $kode melebihi qty_sp. Qty: $qty, Qty_sp: {$uniqueProduks[$kode]['qty_sp']}";
            }
        }

        return $errors;
    }
}