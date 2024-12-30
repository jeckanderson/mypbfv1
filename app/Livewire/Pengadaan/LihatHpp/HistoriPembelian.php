<?php

namespace App\Livewire\Pengadaan\LihatHpp;

use App\Models\ProdukPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HistoriPembelian extends Component
{
    public $id;

    public function render()
    {
        return view('livewire.pengadaan.lihat-hpp.histori-pembelian', [
            'pembelians' => ProdukPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('id_produk', $this->id)
                ->get()
        ]);
    }

    public function simpanRencanaOrder()
    {
        dd('asdklasjkn');
    }
}
