<?php

namespace App\Livewire\Penjualan\CekPesanan;

use App\Models\SPPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CekSpPenjualan extends Component
{
    public $selectedSP = [];

    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('kirim_cek_sp', 1);

        if ($this->search) {
            $query->where('no_reff', 'like', '%' . $this->search . '%')
                ->orWhere('tipe_sp', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_sp', [$this->startDate, $this->endDate]);
        }

        return view('livewire.penjualan.cek-pesanan.cek-sp-penjualan', [
            'spPenjualan' => $query->latest()->get()
        ]);
    }

    public function kirimPenjualan()
    {
        if ($this->selectedSP == null) {
            $this->js("alert('Pilih dulu sp yang akan dikirimkan ke cek sp')");
        }
        $dataSp = SPPenjualan::whereIn('id', $this->selectedSP)->update(['kirim_penjualan' => 1]);
        if ($dataSp) {
            $this->render();
        }
    }

    public function deleteSP($id)
    {
        $deleteSP = SPPenjualan::find($id)->update(['kirim_cek_sp' => 0]);
    }
}
