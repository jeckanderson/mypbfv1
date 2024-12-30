<?php

namespace App\Livewire\Utilities\Piutang;

use App\Models\Pegawai;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\PiutangPengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class TempoPiutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;

    public $pelangganId;
    public $salesId;

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

        $piutang = PiutangPengguna::select(DB::raw('MAX(id) as id'))->when($this->search, function ($query) {
            $query->whereHas('penjualan', function ($query) {
                $query->where('no_faktur', 'like', '%' . $this->search . '%');
            });
        })
            ->when($this->salesId, function ($query) {
                $query->whereHas('getPelanggan', function ($query) {
                    $query->where('sales', $this->salesId);
                });
            })
            ->when($this->pelangganId, function ($query) {
                $query->where('id_pelanggan', 'like', '%' . $this->pelangganId . '%');
            })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                $query->where(function ($query) {
                    $query->whereHasMorph(
                        'sourceable',
                        ['App\Models\PiutangAwal', 'App\Models\Penjualan'],
                        function ($query, $type) {
                            if ($type === 'App\Models\Penjualan') {
                                $query->whereBetween('tempo_kredit', [
                                    \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                                    \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                                ]);
                            } elseif ($type === 'App\Models\PiutangAwal') {
                                $query->whereBetween('tgl_jth_tempo', [
                                    \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                                    \Carbon\Carbon::parse($this->selesaiId)->endOfDay()
                                ]);
                            }
                        }
                    );
                });
            })
            ->with('profile', 'bayar', 'penjualan', 'sourceable', 'detailable')
            ->groupBy('id_penjualan')
            ->pluck('id');
        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire..utilities.piutang.tempo-piutang', [
            'pelanggan' => $pelanggan,
            'piutang' => PiutangPengguna::whereIn('id', $piutang)->get(),
            'pegawais' => Pegawai::where('jabatan', 'Sales')->get()
        ]);
    }
}
