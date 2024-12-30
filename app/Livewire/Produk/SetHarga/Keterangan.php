<?php

namespace App\Livewire\Produk\SetHarga;

use App\Models\DiskonKelompok;
use App\Models\ObatBarang;
use App\Models\Pembelian;
use App\Models\PPN;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use App\Models\StokAwal;
use App\Models\StokOpname;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Keterangan extends Component
{
    public $stoks = [], $pembelians = [], $opnames = [], $id, $selectedStok, $selectedOpname, $stokMasuk, $stokOpname, $pembelianMasuk, $selectedPembelian, $dis1 = '', $dis2 = '', $hppPembelian, $hppFinalPembelian, $produk, $isi;
    public $hidePembelian, $hideStok, $hideOpname, $pembelian, $inc_ppn;

    public function render()
    {
        return view('livewire.produk.set-harga.keterangan');
    }

    public function mount()
    {
        $this->stoks = StokAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_obat_barang', $this->id)->get();
        $this->opnames = StokOpname::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $this->id)->where('sumber', 'Stok Masuk')->get();
        $this->pembelians = ProdukDiterima::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $this->id)->where('id_terima_barang', '!=', null)->get();
        $this->produk = ObatBarang::find($this->id);
    }

    public function updatedSelectedPembelian()
    {
        if ($this->selectedPembelian) {
            $this->resetSelectionsExcept('selectedPembelian');
            $this->selectedStok = null;
            $this->pembelianMasuk = ProdukDiterima::find($this->selectedPembelian);
            if ($this->pembelianMasuk) {
                $harga = floatval(str_replace('.', '', $this->pembelianMasuk->diterimaToPembelian->harga));
                $disc_1 = $harga - ($harga * $this->pembelianMasuk->diterimaToPembelian->disc_1 / 100);
                $disc_2 = $disc_1 - ($disc_1 * (float)$this->pembelianMasuk->diterimaToPembelian->disc_2 / 100);
                $this->hppPembelian = $disc_2;
                $this->hppPembelian *=  round($this->pembelianMasuk->diterimaToPembelian->qty_faktur);
                $total = $this->hppPembelian;
                $this->isi = $this->pembelianMasuk->diterimaToPembelian->produk->isi;
                // $this->hppPembelian -=  $this->pembelianMasuk->diterimaToPembelian->pembelian->hasil_diskon;
                $this->hppPembelian = $total * ($this->pembelianMasuk->diterimaToPembelian->pembelian->diskon / 100);
                $calc = $this->hppPembelian / ($this->pembelianMasuk->diterimaToPembelian->qty_faktur * $this->isi);
                // $this->hppPembelian = ($this->pembelianMasuk->diterimaToPembelian->total / $this->pembelianMasuk->diterimaToPembelian->qty_faktur);
                $this->pembelian = $this->pembelianMasuk->pembelian;
                $this->inc_ppn = $this->pembelianMasuk->pembelian->inc_ppn;
                // $temp = $disc_2 / $this->isi;
                // $this->hppPembelian = $temp;
                // $this->hppPembelian = $this->pembelianMasuk->diterimaToPembelian->pembelian->hasil_diskon / ($this->pembelianMasuk->diterimaToPembelian->qty_faktur * $this->isi) ;
                //hppsatuan
                $hppSatuan = round(($this->pembelianMasuk->diterimaToPembelian->total / $this->pembelianMasuk->diterimaToPembelian->qty_faktur) / $this->pembelianMasuk->diterimaToPembelian->order->produk->isi, 5);

                // $hppSatuan = round($this->pembelianMasuk->diterimaToPembelian->total / $this->pembelianMasuk->diterimaToPembelian->qty_faktur);
                $calulate = ($hppSatuan - $calc);
                // $this->hppPembelian = $calc - $hppSatuan;
                //mencari jumlah kesuluruhan isi
                $id_sp = $this->pembelianMasuk->id_sp;
                $totalIsi = 0;


                foreach (ProdukPembelian::where('id_sp', $id_sp)->get() as $get) {
                    $totalIsi += $get->order->produk->isi * $get->qty_faktur;
                }

                $pengurang = round($this->pembelianMasuk->pembelian->hasil_diskon / $totalIsi, 5);
                $this->hppPembelian = $hppSatuan - $pengurang;

                $this->hppFinalPembelian = $calulate;
                if (intval($this->inc_ppn) == 1) {
                    $this->hppPembelian = round($this->hppPembelian / (1 + (PPN::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->ppn / 100)), 5);
                }
                $this->pembelianMasuk->diterimaToPembelian->update([
                    'hpp_final' => $this->hppPembelian,
                ]);
                $this->dispatch('updateSetHarga', sumber: 'Pembelian', id_sumber: $this->selectedPembelian, hpp: $this->hppPembelian);
                $this->dispatch('updatePembelian', id_pembelian: $this->selectedPembelian, hppFinal: $this->hppPembelian);
                $this->hideStok = '';
                $this->hidePembelian = '';
            }
        }
    }

    public function updatedSelectedStok()
    {
        if ($this->selectedStok) {
            $this->resetSelectionsExcept('selectedStok');
            $this->stokMasuk = StokAwal::find($this->selectedStok);
            $this->dispatch('updateStok', stok_id: $this->selectedStok);
            $isi = DiskonKelompok::where('id_obat_barang', $this->stokMasuk->id_obat_barang)
                ->where('satuan_dasar_beli', $this->stokMasuk->satuan)
                ->first()->isi;
            $this->hppFinalPembelian = null;
            $this->hppPembelian = str_replace('.', '', $this->stokMasuk->hpp) / $isi;
            $this->selectedPembelian = null;
            $this->hidePembelian = null;
            $this->hideStok = null;

            $this->dispatch('updateSetHarga', sumber: 'Stock Awal', id_sumber: $this->selectedStok, hpp: $this->hppPembelian);
        }
    }

    public function updatedSelectedOpname()
    {
        if ($this->selectedOpname) {
            $this->resetSelectionsExcept('selectedOpname');
            $this->stokOpname = StokOpname::find($this->selectedOpname);
            $this->dispatch('updateOpname', opname_id: $this->selectedOpname);
            $this->hppFinalPembelian = null;
            $this->hppPembelian = null;
            $this->selectedPembelian = null;
            $this->hidePembelian = null;
            $this->hideStok = null;
            $this->dispatch('updateSetHarga', sumber: 'Opname', id_sumber: $this->selectedOpname, hpp: $this->hppPembelian);
        }
    }

    private function resetSelectionsExcept($selection)
    {
        if ($selection !== 'selectedPembelian') {
            $this->selectedPembelian = null;
            $this->pembelianMasuk = null;
            $this->hppPembelian = null;
            $this->hppFinalPembelian = null;
            $this->hidePembelian = null;
        }

        if ($selection !== 'selectedStok') {
            $this->selectedStok = null;
            $this->stokMasuk = null;
            $this->hppPembelian = null;
            $this->hppFinalPembelian = null;
            $this->hideStok = null;
        }

        if ($selection !== 'selectedOpname') {
            $this->selectedOpname = null;
            $this->stokOpname = null;
            $this->hppPembelian = null;
            $this->hppFinalPembelian = null;
            $this->hideOpname = null;
        }
    }
}
