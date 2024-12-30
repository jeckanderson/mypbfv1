<?php

namespace App\Livewire\Master;

use App\Models\Ekspedisi;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDataEkspedisi extends Component
{

    public $nama_ekspedisi, $nomor, $id;

    public function render()
    {
        return view('livewire.master.modal-data-ekspedisi');
    }

    public function simpanEkspedisi()
    {
        if ($this->id) {
            $ekspedisi = Ekspedisi::find($this->id);
            $ekspedisi->update([
                'nama_ekspedisi' => $this->nama_ekspedisi,
                'nomor' => $this->nomor
            ]);
            $this->dispatch('refreshTableEkspedisi');
        } else {
            $simpan = Ekspedisi::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'nama_ekspedisi' => $this->nama_ekspedisi,
                'nomor' => $this->nomor
            ]);
            if ($simpan) {
                $this->reset('nama_ekspedisi', 'nomor');
                $this->dispatch('refreshTableEkspedisi');
            }
        }
        return redirect('/ekspedisi');
    }

    public function mount()
    {
        if ($this->id) {
            $ekspedisi = Ekspedisi::find($this->id);
            $this->nama_ekspedisi = $ekspedisi->nama_ekspedisi;
            $this->nomor = $ekspedisi->nomor;
        }
    }
}
