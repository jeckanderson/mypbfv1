<?php

namespace App\Livewire\PembuatanSp;

use App\Models\Pembelian;
use App\Models\RencanaOrder;
use App\Models\SPPembelian;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SuratPesanan extends Component
{
    protected $listeners = ['refresh' => 'render'];
    public $nomorSp, $tipeSp, $tglAwal, $tglAkhir;

    public function render()
    {
        $query = SPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan);

        if ($this->nomorSp) {
            $query->where('no_sp', 'like', '%' . $this->nomorSp . '%');
        }

        if ($this->tipeSp) {
            $query->where('tipe_sp', $this->tipeSp);
        }

        if ($this->tglAwal) {
            $query->whereDate('tgl_sp', '>=', $this->tglAwal);
        }

        if ($this->tglAkhir) {
            $query->whereDate('tgl_sp', '<=', $this->tglAkhir);
        }

        return view('livewire.pembuatan-sp.surat-pesanan', [
            'surats' => $query->get()
        ]);
    }

    public function mount()
    {
        $this->tglAkhir = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->tglAwal = Carbon::now()->startOfMonth()->format('Y-m-d');
    }

    public function deleteSP($id)
    {
        $surat = SPPembelian::find($id);
        $idOrders = json_decode($surat->id_order);
        if ($surat) {
            $surat->delete();
            RencanaOrder::whereIn('id', $idOrders)->update(['status' => 0]);
        }
        $this->dispatch('refresh');
        session()->flash('success', 'Data berhasil dihapus!');
    }
}
