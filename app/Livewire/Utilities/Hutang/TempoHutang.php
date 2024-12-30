<?php

namespace App\Livewire\Utilities\Hutang;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HutangPengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TempoHutang extends Component
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
            $this->mulaiId = Carbon::now()->startOfMonth()->format('Y-m-d');
        }

        if (!$this->selesaiId) {
            $this->selesaiId = Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $hutang = HutangPengguna::select(DB::raw('MAX(id) as id'))
            ->when($this->search, function ($query) {
                $query->whereHas('sourceable', function ($query) {
                    $query->where('no_faktur', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->spId, function ($query) {
                $query->where('id_suplier', 'like', '%' . $this->spId . '%');
            })
            ->groupBy('sourceable_type', 'sourceable_id')
            ->orderBy('id', 'desc')
            ->pluck('id');
        return view('livewire..utilities.hutang.tempo-hutang', [
            'suplier' => $suplier,
            'hutang' =>  HutangPengguna::whereIn('id', $hutang)->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->where(function ($query) {
                    $query->whereHasMorph(
                        'sourceable',
                        ['App\Models\Pembelian', 'App\Models\HutangAwal'],
                        function ($query, $type) {
                            if ($type === 'App\Models\Pembelian') {
                                $query->whereBetween('tempo_kredit', [$this->mulaiId, $this->selesaiId]);
                            } elseif ($type === 'App\Models\HutangAwal') {
                                $query->whereBetween('tgl_jth_tempo', [$this->mulaiId, $this->selesaiId]);
                            }
                        }
                    );
                });
            })->get()
        ]);
    }
}
