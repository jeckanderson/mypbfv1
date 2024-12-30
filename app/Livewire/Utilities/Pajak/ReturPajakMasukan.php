<?php

namespace App\Livewire\Utilities\Pajak;

use App\Models\ReturPembelian;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReturPajakMasukan extends Component
{
    public $startDate, $endDate, $suplier;

    public function render()
    {
        $returPembelian = ReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->startDate && $this->endDate,function($q){
            $q->whereBetween(DB::raw('DATE(tgl_input)'), [$this->startDate, $this->endDate]);
        })
        ->when($this->suplier,function($q){
            $q->where('id_suplier', $this->suplier);
        })
        ->get();
        $supliers =  Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire.utilities.pajak.retur-pajak-masukan', compact('returPembelian','supliers'));
    }
}
