<?php

namespace App\Livewire\Penjualan\SpPenjualan;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalDaftarPelanggan extends Component
{
    public $selectedPelanggan;

    public function render()
    {
        $pelanggans = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        foreach ($pelanggans as $pelanggan) {
            $latestPiutang = $pelanggan->piutang()->latest()->first();
            $pelanggan->sisa_hutang = $latestPiutang ? $latestPiutang->sisa_hutang : null;
        }

        return view('livewire.penjualan.sp-penjualan.modal-daftar-pelanggan', [
            'pelanggans' => $pelanggans,
        ]);
    }


    public function pilihPelanggan()
    {
        $this->dispatch('insertPelanggan', pelanggan: $this->selectedPelanggan);
    }
}
