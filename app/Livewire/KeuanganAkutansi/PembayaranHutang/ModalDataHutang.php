<?php

namespace App\Livewire\KeuanganAkutansi\PembayaranHutang;

use Livewire\Component;
use Livewire\Attributes\On;

class ModalDataHutang extends Component
{
    public $hutang = [];
    public function render()
    {
        return view('livewire.keuangan-akutansi.pembayaran-hutang.modal-data-hutang');
    }

    #[On('dataSuplier')]
    public function getHutang()
    {
    }
}
