<?php

namespace App\Livewire\Utilities\Hutang;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HutangPengguna;
use Illuminate\Support\Facades\Auth;


class BayarHutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;

    public $spId;

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
        $hutang = HutangPengguna::has('bayarss')->when($this->search, function ($query) {
            $query->whereHas('sourceable', function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->spId, function ($query) {
                $query->where('id_suplier', 'like', '%' . $this->spId . '%');
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->whereHas('bayar', function ($query) {
                    $query->whereBetween('tgl_input', [$this->mulaiId, $this->selesaiId]);
                });
            })
            ->with('profile', 'bayar', 'sourceable', 'detailable')
            ->paginate(10);
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire..utilities.hutang.bayar-hutang', [
            'suplier' => $suplier,
            'hutang' => $hutang
        ]);
    }
}
