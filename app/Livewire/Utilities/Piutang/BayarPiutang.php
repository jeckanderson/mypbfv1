<?php

namespace App\Livewire\Utilities\Piutang;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\PiutangPengguna;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class BayarPiutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;
    public $pelangganId;
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
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        $piutang = PiutangPengguna::when($this->search, function ($query) {
            $query->whereHas('sourceable', function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->pelangganId, function ($query) {
                $query->where('id_pelanggan', 'like', '%' . $this->pelangganId . '%');
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->whereHas('bayar', function ($query) {
                    $query->whereBetween('tgl_input', [
                        $this->mulaiId,
                        $this->selesaiId
                    ]);
                });
                $query->orWhereHas('penjualan', function ($query) {
                    $query->whereBetween('tgl_input', [
                        \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                        \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                    ]);
                });
            })
            ->where('nominal_bayar', '>', 0)
            ->with('profile', 'penjualan', 'sourceable', 'detailable')
            ->paginate(10);

        return view('livewire.utilities.piutang.bayar-piutang', [
            'pelanggan' => $pelanggan,
            'piutang' => $piutang,
        ]);
    }
}
