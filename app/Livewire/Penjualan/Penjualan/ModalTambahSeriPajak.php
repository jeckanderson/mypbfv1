<?php

namespace App\Livewire\Penjualan\Penjualan;

use App\Models\Pajak;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ModalTambahSeriPajak extends Component
{
    use WithPagination;

    public $selectedPajak;
    public $search = '';
    public $idPenjualan;
    public $id;

    public function mount()
    {
        $this->idPenjualan = $this->id;
    }

    public function render()
    {
        return view('livewire.penjualan.penjualan.modal-tambah-seri-pajak', [
            'seriPajak' => Pajak::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('pajak', 'LIKE', '%' . $this->search . '%')
                ->where('status_digunakan', 0)
                ->paginate(10),
            'idPenjualan' => $this->idPenjualan
        ]);
    }

    public function simpanSeriPajak()
    {
        $cekPajak = Pajak::where('id', $this->selectedPajak);
        if ($cekPajak->count() < 1) {
            $this->js("alert('No Seri Pajak tidak ditemukan')");
            return;
        }
        $cekPajak = $cekPajak->first();
        if ($cekPajak->status_digunakan == 1) {
            $this->js("alert('No Seri Pajak sudah digunakan')");
            return;
        }

        $penjualan=Penjualan::find($this->idPenjualan);
        if($penjualan->no_seri_pajak<>'' and $penjualan->no_seri_pajak<>$cekPajak->pajak){
            Pajak::where('pajak',$penjualan->no_seri_pajak)->update(['status_digunakan'=>0]);            
        }
        $penjualan->update(['no_seri_pajak' => $cekPajak->pajak]);
        $cekPajak->update(['status_digunakan'=> 1]);
        return redirect('/penjualan');
    }

    public function pilihPajak()
    {
        $this->dispatch('pilihPajak', id_pajak: $this->selectedPajak);
    }
}
