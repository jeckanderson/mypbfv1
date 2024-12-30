<?php

namespace App\Livewire\Penjualan\Penjualan;

use App\Models\Pajak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ModalCariSeriPajak extends Component
{
    use WithPagination;

    public $selectedPajak;
    public $search = '';

    public function render()
    {
        return view('livewire.penjualan.penjualan.modal-cari-seri-pajak', [
            'seriPajak' => Pajak::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('pajak', 'LIKE', '%' . $this->search . '%')
                ->where('status_digunakan', 0)
                ->paginate(10)
        ]);
    }

    public function pilihPajak()
    {
        $this->dispatch('pilihPajak', id_pajak: $this->selectedPajak);
    }
}
