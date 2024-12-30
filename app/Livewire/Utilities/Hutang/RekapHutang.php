<?php

namespace App\Livewire\Utilities\Hutang;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\HutangPengguna;
use Livewire\WithPagination;
class RekapHutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;



    public $search = '';
  

    protected $listeners = ['refreshTable' => '$refresh'];
    public function render()
    {
        if (!$this->mulaiId) {
            $this->mulaiId = Carbon::now()->firstOfMonth()->format('Y-m-d');
        }
    
        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
    
        return view('livewire..utilities.hutang.rekap-hutang', [
            'hutang' => HutangPengguna::when($this->search, function ($query) {
                    $query->whereHas('suplier', function ($query) {
                        $query->where('nama_suplier', 'like', '%' . $this->search . '%');
                    });
                })
               

                ->when($this->selesaiId && $this->mulaiId, function ($query) {
                    if ($this->mulaiId == $this->selesaiId) {
                        $query->whereHas('pembelian', function ($query) {
                            $query->where('tgl_input', $this->mulaiId);
                        });
                    } else {
                        $query->whereHas('pembelian', function ($query) {
                            $query->whereBetween('tgl_input', [$this->mulaiId, $this->selesaiId]);
                        });
                        
                    }
                })
    
                ->paginate(10)
             
        ]);
        
    }
}
