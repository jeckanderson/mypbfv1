<?php

namespace App\Livewire\Pembelian;

use App\Models\Pembelian;
use Livewire\Component;

class EditTax extends Component
{
    public function render()
    {
        return view('livewire.pembelian.edit-tax');
    }

    public $pembelianId;
    public $no_faktur_pajak;
    public $tgl_faktur_pajak;
    public $kompensasi_pajak;

    protected $rules = [
        'no_faktur_pajak' => 'required|string',
        'tgl_faktur_pajak' => 'required|date',
        'kompensasi_pajak' => 'required|string',
    ];

    public function mount($pembelianId)
    {
        $pembelian = Pembelian::findOrFail($pembelianId);
        $this->pembelianId = $pembelian->id;
        $this->no_faktur_pajak = $pembelian->no_faktur_pajak;
        $this->tgl_faktur_pajak = $pembelian->tgl_faktur_pajak;
        $this->kompensasi_pajak = $pembelian->kompensasi_pajak;
    }

    public function save()
    {
        $this->validate();

        $pembelian = Pembelian::findOrFail($this->pembelianId);
        $pembelian->no_faktur_pajak = $this->no_faktur_pajak;
        $pembelian->tgl_faktur_pajak = $this->tgl_faktur_pajak;
        $pembelian->kompensasi_pajak = $this->kompensasi_pajak;
        $pembelian->save();

        session()->flash('success', 'Tax information updated successfully.');

        $this->dispatch('taxUpdated');
    }
}
