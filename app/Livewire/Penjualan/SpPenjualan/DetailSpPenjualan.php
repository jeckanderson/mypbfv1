<?php

namespace App\Livewire\Penjualan\SpPenjualan;

use App\Models\ObatBarang;
use App\Models\Pegawai;
use Livewire\Attributes\Validate;
use App\Models\Pelanggan;
use App\Models\ProdukPenjualan;
use App\Models\SPPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class DetailSpPenjualan extends Component
{
    public $tambahProduk;
    //masuk from
    public $tgl_input, $no_reff, $tgl_sp, $pelanggan, $sales, $no_sp, $tipe_sp, $simpan = [], $keterangan, $id_pelanggan, $id_sales;

    public function render()
    {
        return view('livewire.penjualan.sp-penjualan.detail-sp-penjualan', [
            'dataProduk' => ProdukPenjualan::where('id_user', Auth::id())->where('sp_terbuat', 0)->get(),
            'produks' => ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->where('status', 1)->get()
        ]);
    }

    public function updatedTambahProduk()
    {
        ProdukPenjualan::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_sp_penjualan' => '-',
            'id_user' => Auth::id(),
            'id_produk' => $this->tambahProduk,
            'qty_sp' => 0,
            'satuan' => '-'
        ]);

        $this->reset('tambahProduk');
    }

    public function mount()
    {
        $urutan = str_pad(SPPenjualan::count() + 1, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/SPJL/' . date('m-y');
        $this->tgl_input = now()->toDateString();
        $this->tgl_sp = now()->toDateString();
    }

    #[On('insertPelanggan')]
    public function onGetPelanggan($pelanggan)
    {
        $DataPelanggan = Pelanggan::find($pelanggan);
        $this->id_pelanggan = $pelanggan;
        $this->pelanggan = $DataPelanggan->nama;
        $this->id_sales = $DataPelanggan->sales;
        $this->sales = Pegawai::find($DataPelanggan->sales)->nama_pegawai;
    }

    #[On('insertProduk')]
    public function onGetProduk($produks)
    {
        $takeProduk = ObatBarang::whereIn('id', $produks)->get();
        foreach ($takeProduk as $key => $prod) {
            ProdukPenjualan::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_sp_penjualan' => '-',
                'id_user' => Auth::id(),
                'id_produk' => $prod->id,
                'qty_sp' => 0,
                'satuan' => '-'
            ]);
        }
        $this->render();
    }

    public function simpanSPPenjualan()
    {
        $this->validate([
            'pelanggan' => 'required',
            'sales' => 'required',
        ]);
        $cekSp=SPPenjualan::where('no_reff',$this->no_reff);
        if($cekSp->count()>0){
            $this->js("alert('Data Surat Pesanan Penjualan sudah ada')");
            return;
        }
        // $urutan = str_pad(SPPenjualan::count() + 1, 6, '0', STR_PAD_LEFT);
        $sppenjualan = SPPenjualan::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'tgl_input' => $this->tgl_input,
            'no_reff' => $this->no_reff,
            'tgl_sp' => $this->tgl_sp,
            'no_sp' => $this->no_sp,
            'pelanggan' => $this->id_pelanggan,
            'sales' => $this->id_sales,
            'tipe_sp' => $this->tipe_sp,
            'sumber' => 'Website',
            'keterangan' => $this->keterangan
        ]);
        if ($sppenjualan) {
            $produkPenjualan = ProdukPenjualan::where('id_user', Auth::id())->where('id_sp_penjualan', '-')->get();
            foreach ($this->simpan as $key => $prod) {
                $produkPenjualan[$key]->update([
                    'id_sp_penjualan' => $sppenjualan->id,
                    'qty_sp' => $prod['qty_sp'],
                    'satuan' => $prod['satuan'],
                    'sp_terbuat' => 1
                ]);
            }
        }

        return redirect('/sp-penjualan');
    }

    public function hapusProduk($id)
    {
        ProdukPenjualan::find($id)->delete();
        $this->render();
    }
}
