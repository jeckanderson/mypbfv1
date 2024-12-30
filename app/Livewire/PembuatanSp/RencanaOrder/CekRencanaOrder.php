<?php

namespace App\Livewire\PembuatanSp\RencanaOrder;

use App\Models\RencanaOrder;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CekRencanaOrder extends Component
{
    use WithPagination;
    protected $listeners = ['refreshChildComponents' => '$refresh'];
    public $cari, $carinama = '';

    public function render()
    {
        $query = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->when($this->cari, function ($q) {
            $q->find($this->cari);
        })->paginate(5);

        // dd($query);

        return view('livewire.pembuatan-sp.rencana-order.cek-rencana-order', [
            'dataSupplier' => $query,
            'supliers' => Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }
    public function updatedCari()
    {
        // Emit event untuk memberitahu komponen child agar re-render
        $this->dispatch('refreshChildComponents');
    }
    public function initializeComponent()
    {
        // Tidak ada pemrosesan tambahan
    }
}
