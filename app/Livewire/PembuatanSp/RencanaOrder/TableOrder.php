<?php

namespace App\Livewire\PembuatanSp\RencanaOrder;

use App\Models\RencanaOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TableOrder extends Component
{
    public $sup, $loadingItemId, $updateTypes = [], $selectAll = false,  $search = '', $nama_suplier;
    protected $listeners = ['refreshChildComponents' => '$refresh'];
    public function render()
    {
        $query = RencanaOrder::query()
            ->where('id_suplier', $this->sup->id)
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('status', 0);

        if (!empty($this->search)) {
            $query->whereHas('produk', function ($query) {
                $query->where('nama_obat_barang', 'like', '%' . $this->search . '%');
            });
        }

        $orders = $query->get();
        return view('livewire.pembuatan-sp.rencana-order.table-order', [
            'updateTypes' => $this->updateTypes,
            'orders' => $orders
        ]);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->updateTypes = RencanaOrder::where('id_suplier', $this->sup->id)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('status', 0)->pluck('id')->map(fn ($id) => (string)$id)->toArray();
        } else {
            $this->updateTypes = [];
        }
    }

    #[On('refresh')]
    public function getUpdate()
    {
        $this->updateTypes = [];
        return view('livewire.pembuatan-sp.rencana-order.table-order');
    }

    public function deleteProduk($id)
    {
        $this->loadingItemId = $id;
        $order = RencanaOrder::find($id);
        if ($order) {
            $order->delete();
        }
        $this->dispatch('refresh');
        session()->flash('success', 'Data berhasil dihapus!');
    }

    public function updateProduk()
    {
        $this->dispatch('updateProduk', updateTypes: $this->updateTypes);
    }
}