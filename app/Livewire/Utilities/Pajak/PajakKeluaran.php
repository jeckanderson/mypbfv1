<?php

namespace App\Livewire\Utilities\Pajak;

use App\Models\Pelanggan;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PajakKeluaran extends Component
{
    public $startDate, $endDate, $pelanggan;

    public function render()
    {
        $penjualans = Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->startDate && $this->endDate,function($q){
            $q->whereBetween(DB::raw('DATE(tgl_faktur)'), [$this->startDate, $this->endDate]);
        })->when($this->pelanggan,function($q){
            $q->where('pelanggan', $this->pelanggan);
        })->get();
        $pelanggans = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        return view('livewire.utilities.pajak.pajak-keluaran', compact('penjualans','pelanggans'));
    }
}