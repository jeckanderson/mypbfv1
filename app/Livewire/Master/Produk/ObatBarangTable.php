<?php

namespace App\Livewire\Master\Produk;

use Livewire\Component;
use App\Models\DaftarObat;
use App\Models\Golongan;
use App\Models\JenisObatBarang;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Produsen;
use App\Models\Satuan;
use App\Models\SubGolongan;
use Illuminate\Support\Facades\Auth;

class ObatBarangTable extends Component
{
    public $cari;

    public function render()
    {
        $obat_barang = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->when($this->cari, function ($q) {
                $q->where('id', $this->cari);
            })
            ->orderBy('nama_obat_barang', 'asc');
        return view('livewire.master.produk.obat-barang-table', [
            'title' => 'master',
            'produks' => ObatBarang::all(),
            'obat_barang' =>  $obat_barang->paginate(20),
            'satuans' => Satuan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'golongans' => Golongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'sub_golongans' => SubGolongan::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'jenis_obat' => JenisObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'produsens' => Produsen::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'kelompoks' => Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }
}
