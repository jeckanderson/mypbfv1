<?php

namespace App\Livewire\Penjualan\SpPenjualan;

use App\Models\ProdukPenjualan;
use App\Models\SPPenjualan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarSp extends Component
{
    public $selectedSP = [];

    public $search = '', $startDate = '', $endDate = '';

    public function render()
    {
        $query = SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->search) {
            $query->where('no_sp', 'like', '%' . $this->search . '%')
                ->orWhere('tipe_sp', 'like', '%' . $this->search . '%');
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_sp', [$this->startDate, $this->endDate]);
        }

        return view('livewire.penjualan.sp-penjualan.daftar-sp', [
            'daftarSP' => $query->get()
        ]);
    }

    public function hapusSP($id)
    {
        $sp = SPPenjualan::find($id)->delete();
        if ($sp) {
            ProdukPenjualan::where('id_sp_penjualan', $id)->delete();
        }
        $this->render();
    }

    public function kirimCekSP()
    {
        if ($this->selectedSP == null) {
            $this->js("alert('Pilih dulu sp yang akan dikirimkan ke cek sp')");
        }
        $dataSp = SPPenjualan::whereIn('id', $this->selectedSP)->update(['kirim_cek_sp' => 1]);

        if ($dataSp) {
            $this->js("alert('Berhasil! berhasil mengirim ke cek surat pesanan')");
            return redirect('/sp-penjualan');
        } else {
            $this->js("alert('Gagal! terjadi kesalahan dalam mengubah data')");
        }
    }
}
