<?php

namespace App\Livewire\Master\Pelanggan;

use App\Models\AreaRayon;
use App\Models\Pegawai;
use App\Models\Sales;
use App\Models\SubRayon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalPelanggan extends Component
{
    public $pelanggan, $dataSales = [], $spv, $rayons = [], $sub_rayons = [];

    public function render()
    {
        return view('livewire.master.pelanggan.modal-pelanggan', [
            'pegawais' => Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('marketing', 'on')->get(),
        ]);
    }

    public function updatedSpv()
    {
        if ($this->spv) {
            $sales = Sales::where('supervisor', $this->spv);
            $this->rayons = AreaRayon::whereIn('id', $sales->pluck('area_rayon'))->get();
            $this->sub_rayons = SubRayon::whereIn('id', $sales->pluck('sub_rayon'))->get();
            $this->dataSales = $sales->get();
        } else {
            $this->dataSales = [];
            $this->rayons = [];
            $this->sub_rayons = [];
        }
    }

    public function mount()
    {
        if ($this->pelanggan) {
            $this->spv = $this->pelanggan->supervisor;
            $sales = Sales::where('supervisor', $this->spv);
            $this->rayons = AreaRayon::whereIn('id', $sales->pluck('area_rayon'))->get();
            $this->sub_rayons = SubRayon::whereIn('id', $sales->pluck('sub_rayon'))->get();
        }
    }
}