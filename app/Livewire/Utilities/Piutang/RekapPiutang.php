<?php

namespace App\Livewire\Utilities\Piutang;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\PiutangPengguna;
use Livewire\WithPagination;

class RekapPiutang extends Component
{
    use WithPagination;
    public $selesaiId;

    public $mulaiId;

    public $search = '';
  

    protected $listeners = ['refreshTable' => '$refresh'];
    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->format('Y-m-d');
        }
    
        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->format('Y-m-d');
        }
        return view('livewire..utilities.piutang.rekap-piutang',[
            'piutang' => PiutangPengguna::when($this->search, function ($query) {
                $query->whereHas('getPelanggan', function ($query) {
                    $query->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                if ($this->mulaiId == $this->selesaiId) {
                    $query->whereHas('penjualan', function ($query) {
                        $query->where('tgl_input', $this->mulaiId);
                    });
                } else {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $this->selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $this->mulaiId)->startOfDay();
                    $query->whereHas('penjualan', function ($query) use ($finalStartDate, $finalEndDate) {
                        $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
                    });
                }
            })
            ->paginate(10)
         
        ]);
    }
}
