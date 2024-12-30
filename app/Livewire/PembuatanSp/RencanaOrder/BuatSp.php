<?php

namespace App\Livewire\PembuatanSp\RencanaOrder;

use App\Models\NoSPPembelian;
use App\Models\RencanaOrder;
use App\Models\SPPembelian;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BuatSp extends Component
{
    public $noSp, $tipe, $disabled = 'disabled', $active = true, $tgl_sp, $products = [], $keterangan, $sup;

    protected $listeners = ['updateProduk' => 'updateProduk','refreshChildComponents' => '$refresh'];

    public function render()
    {
        return view('livewire.pembuatan-sp.rencana-order.buat-sp');
    }

    public function updateProduk($updateTypes)
    {
        $this->products = $updateTypes;
        $this->tgl_sp = now()->toDateString();
    }

    public function mount()
    {
        $this->noSp = new NoSPPembelian();
    }

    public function updatedTipe($value)
    {
        $lastOrder = SPPembelian::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        if (!is_null($value)) {
            $this->noSp = $urutan . ' - ' . NoSPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('nomor_surat', 'LIKE', '%' . $value . '%')
                ->first()->nomor_surat;
        } else {
            $this->noSp = $value;
        }
    }

    public function updatedActive()
    {
        $this->disabled = $this->active ? 'disabled' : '';
    }


    public function buatSP()
    {
        $lastOrder = SPPembelian::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);

        if ($this->disabled) {
            $nomor = $urutan . ' - ' . NoSPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('nomor_surat', 'LIKE', '%' . $this->tipe . '%')
                ->first()->nomor_surat;
        } else {
            $nomor = $this->noSp;
        }

        if ($this->products == null) {
            session()->flash('error', 'Tidak ada barang dipilih!');
        } else {
            SPPembelian::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_suplier' => $this->sup->id,
                'no_reff' => $urutan . '/SP/' . date('m-y'),
                'tgl_sp' => $this->tgl_sp,
                'tipe_sp' => $this->tipe ?? '',
                'no_sp' => $nomor,
                'id_order' => json_encode($this->products),
                'keterangan' => $this->keterangan ?? '-',
            ]);

            RencanaOrder::whereIn('id', $this->products)->update(['status' => 1]);

            $this->resetExcept('sup');
            $this->dispatch('refresh');
            session()->flash('success', 'Berhasil!, SP anda berhasil dibuat');
        }
    }
}
