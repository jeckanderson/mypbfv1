<?php

namespace App\Livewire\Dashboard;

use App\Models\Gudang;
use App\Models\HistoryStok;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardGudang extends Component
{
    public $row = 10, $selectedGudang, $expDateFrom, $expDateTo;

    public function render()
    {
        $historys = HistoryStok::query()
            ->where('id_perusahaan', Auth::user()->id_perusahaan)
            ->groupBy('id_gudang', 'id_rak', 'id_sub_rak', 'id_produk');

        if ($this->selectedGudang) {
            $historys->where('id_gudang', $this->selectedGudang);
        }

        if ($this->expDateFrom) {
            $historys->whereDate('exp_date', '>=', $this->expDateFrom);
        }

        if ($this->expDateTo) {
            $historys->whereDate('exp_date', '<=', $this->expDateTo);
        }

        $historys = $historys->paginate($this->row);
        return view('livewire.dashboard.dashboard-gudang', [
            'produks' => $historys,
            'gudangs' => Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }
}
