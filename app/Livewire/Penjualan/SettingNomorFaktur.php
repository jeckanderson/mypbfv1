<?php

namespace App\Livewire\Penjualan;

use App\Models\SetNoFaktur;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SettingNomorFaktur extends Component
{
    public $faktur, $footer;

    public function render()
    {
        return view('livewire.penjualan.setting-nomor-faktur', [
            'title' => 'transaksi'
        ]);
    }

    public function simpanNoFaktur()
    {
        $nomor = SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        if ($nomor) {
            $nomor->update([
                'no_surat' => $this->faktur,
            ]);
        } else {
            SetNoFaktur::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_surat' => $this->faktur,
            ]);
        }
        session()->flash('success', 'Nomor Faktur berhasil disimpan!');
    }

    public function simpanFooter()
    {
        $nomor = SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        if ($nomor) {
            $nomor->update([
                'footer' => $this->footer,
            ]);
        } else {
            SetNoFaktur::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'footer' => $this->footer,
            ]);
        }
        session()->flash('success', 'Footer berhasil disimpan!');
    }

    public function mount()
    {
        $nomor = SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        if ($nomor) {
            $this->faktur = $nomor->no_surat;
            $this->footer = $nomor->footer;
        }
    }
}
