<?php

namespace App\Livewire\Penjualan;

use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\Pajak;
use App\Models\Penjualan;
use App\Models\PiutangPengguna;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DataPenjualan extends Component
{
    public function render()
    {
        return view('livewire.penjualan.data-penjualan', [
            'penjualans' => Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function hapusPenjualan($id)
    {
        $hapus = Penjualan::find($id);
        if ($hapus) {
            if($hapus->no_seri_pajak<>''){
                $cekPajak=Pajak::where('pajak',$hapus->no_seri_pajak);
                if($cekPajak->count()>0){
                    $cekPajak->update(['status_digunakan'=>0]);
                }
            }
            Jurnal::where('id_sumber', $id)->where('sumber', 'Penjualan')->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            HistoryStok::where('no_reff', $hapus->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            PiutangPengguna::where('id_penjualan',$id)->where('sumber','penjualan')->delete();
            $hapus->delete();
            $this->render();
        }
    }
}
