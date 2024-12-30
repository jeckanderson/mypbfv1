<?php

namespace App\Livewire\Utilities\Pajak;

use App\Models\Pembelian;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PajakMasukan extends Component
{
    public $startDate, $endDate, $startKompensasi, $endKompensasi, $suplier;

    public function render()
    {
        $pembelians = Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->startDate && $this->endDate,function($q){
            // dd([$this->startDate, $this->endDate]);
            $q->whereBetween(DB::raw('DATE(tgl_faktur)'), [$this->startDate, $this->endDate]);
        })
        ->when($this->startKompensasi && $this->endKompensasi,function($q){
            $q->whereBetween('kompensasi_pajak', [$this->startKompensasi, $this->endKompensasi]);
        })
        ->when($this->suplier,function($q){
            $q->where('suplier', $this->suplier);
        })->get();
        $supliers = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire.utilities.pajak.pajak-masukan', compact('pembelians','supliers'));
    }
}
