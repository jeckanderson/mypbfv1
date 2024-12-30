<?php

namespace App\Livewire\Utilities\Hutang;

use Carbon\Carbon;
use App\Models\Suplier;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Exports\Kartu\Hutang;
use App\Models\HutangPengguna;
use App\Models\ReturPembelian;

use function PHPSTORM_META\type;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class KartuHutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId;

    public $spId;

    public $search = '';
    protected $listeners = ['refreshTable' => '$refresh'];
    public $total = 0;
    public $data = [];

    public function mount()
    {
        $this->mulaiId = date('Y-m-01');
        $this->selesaiId = date('Y-m-t');
    }

    public function render()
    {
        $this->reset('data','total');
        $hutang_pengguna = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->has('hutangs')->with(['hutangs' => function ($q) {
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        }, 'hutangs.sourceable', 'hutangs.sourceable.hutang_pengguna', 'hutangs.sourceable.hutang_pengguna.detailable'])
            ->when($this->spId, function ($q) {
                $q->where('id', $this->spId);
            })
            ->when($this->mulaiId && $this->selesaiId, function ($query) {
                $query->whereHas('hutangs', function ($subQuery) {
                    // $subQuery->where('sumber','like','%'.$this->search.'%');
                    $subQuery->whereHasMorph('sourceable', '*', function ($subSubQuery) {
                        // Search by 'no_faktur' on the polymorphic relationship
                        $subSubQuery->whereRaw("DATE(tgl_faktur) BETWEEN ? AND ?", [$this->mulaiId, $this->selesaiId]);
                    });
                });
            })
            // Eager load relationships without grouping inside with()
            ->with([
                'hutangs' => function ($q) {
                    return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
                },
                'hutangs.sourceable.hutang_pengguna',
                'hutangs.sourceable.hutang_pengguna.detailable'
            ])
            ->paginate(10);

        // foreach ($hutang_pengguna as $pengguna) {

        //     foreach ($pengguna->hutangs as $c)
        //         if (!is_null($c->sourceable)) {
        //             $w = 0;
        //             foreach ($c->sourceable->hutang_pengguna as $d) {
        //                 $w = str_replace('.', '', $d->sisa_hutang);
        //             }
        //             $this->total += $w;
        //         }
        // }
        // $this->total = number_format($this->total, 0, ',', '.');

        // $hutang = ReturPembelian::when($this->search, function ($query) {
        //     $query->where('no_faktur', 'like', '%' . $this->search . '%');
        // })
        // ->when($this->spId, function ($query) {
        //     $query->where('id_suplier', 'like', '%' . $this->spId . '%');
        // })
        // ->when($this->selesaiId && $this->mulaiId, function ($query) {
        //     if ($this->mulaiId == $this->selesaiId) {
        //         $query->whereHas('pembelian', function ($query) {
        //             $query->where('tgl_input', $this->mulaiId);
        //         });
        //     } else {
        //         $finalEndDate = Carbon::createFromFormat('Y-m-d', $this->selesaiId)->endOfDay();
        //         $finalStartDate = Carbon::createFromFormat('Y-m-d', $this->mulaiId)->startOfDay();
        //         $query->whereHas('pembelian', function ($query) use ($finalStartDate, $finalEndDate) {
        //             $query->whereBetween('tgl_input', [$finalStartDate, $finalEndDate]);
        //         });
        //     }
        // })
        // ->with('profile','suplier','pembelian')
        // ->paginate(10);

        $sum_total_tagihan = 0;
        $sum_total_bayar = 0;
        $sum_total_retur = 0;
        $sum_total_sisa_hutang = 0;
        
        $dd = 0;
        foreach ($hutang_pengguna as $key => $pengguna) {
            $this->total = 0;
            $s = 0;
            foreach ($pengguna->hutangs as $i => $c) {
                // if (!is_null($c->sourceable)) {
                //     $w = 0;
                //     foreach ($c->sourceable->hutang_pengguna as $d) {
                //         $w = str_replace('.', '', $d->sisa_hutang);
                //     }
                //     $this->total += $w;
                // }
                $this->data[$key]['name'] = $pengguna->nama_suplier;

                $k = 1;
                $this->data[$key]['total'] = 0;
                foreach (
                    $pengguna->hutangs()->with([
                        'sourceable',
                        'sourceable.hutang_pengguna',
                        'sourceable.hutang_pengguna.detailable'
                    ])->when($this->mulaiId && $this->selesaiId, function ($query) {
                        $query->whereHas('sourceable', function ($subQuery) {
                            $subQuery->whereRaw("DATE(tgl_faktur) BETWEEN ? AND ?", [$this->mulaiId, $this->selesaiId])->orderBy('tgl_faktur', 'asc');
                        });
                    })->groupBy('sourceable_type','sourceable_id')->get() as $j => $piutang
                ) {
                    $total_tagihan = 0;
                    $bayar = 0;
                    $retur = 0;
                    $sisa_hutang = 0;
                    $total_tagihan += $piutang->sourceable->total_tagihan;
                    $sum_total_tagihan += $piutang->total_hutang;

                    
                    $datas = [];
                    $datas['no'] = $k;
                    $datas['tanggal'] = $piutang->created_at->format('d-m-Y') ?? '-';
                    $datas['no_reff'] =  $piutang->sourceable->no_reff ?? '-';
                    $datas['tanggal_faktur'] = $piutang->sourceable->tgl_faktur->format('d-m-Y');
                    $datas['no_faktur'] = $piutang->sourceable->no_faktur;
                    $datas['tempo_kredit'] = $piutang->sourceable->tempo_kredit->format('d-m-Y');
                    $datas['total_tagihan'] = number_format($piutang->sourceable->total_tagihan ?? 0, 0, ',', '.');
                    $this->data[$key]['piutang'][$j] = $datas;
                    $k++;
                    $kj = 1;
                    foreach ($piutang->sourceable->hutang_pengguna as $x => $detail) {
                        if ($detail->detailable_type != \App\Models\ReturPembelian::class) {
                            $bayar += str_replace('.', '', $detail->nominal_bayar);
                        }

                        $sisa_hutang += str_replace('.', '', $detail->sisa_hutang);
                        $sum_total_sisa_hutang += str_replace(
                            '.',
                            '',
                            $detail->sisa_hutang,
                        );
                        if ($detail->detailable_type == \App\Models\ReturPembelian::class) {
                            $retur += str_replace(
                                '.',
                                '',
                                $detail->detailable->total,
                            );
                            $sum_total_retur += $retur;
                        }
                        $details = [];
                        $details['no'] = $kj;
                        $details['no_reff'] = $detail->detailable->no_reff ?? '-';
                        $details['tanggal'] = $detail->detailable->created_at->format('d-m-Y') ?? '-';
                        $details['retur'] = $detail->detailable_type == \App\Models\ReturPembelian::class ? doubleval(str_replace('.', '', $detail->detailable->total)) : 0;
                        $details['bayar_retur'] = $detail->detailable_type != \App\Models\ReturPembelian::class ? doubleval(str_replace('.', '', $detail->nominal_bayar)) : 0;
                        $details['sisa_hutang'] = doubleval(str_replace('.', '', $detail->sisa_hutang));
                        $details['uang_retur'] = $detail->detailable_type == \App\Models\ReturPembelian::class ? doubleval(str_replace('.', '', $detail->detailable->uang_retur)) : 0;
                        $details['type'] = ucwords(str_replace('_', ' ', Str::snake(str_replace('App\\Models\\', '', $detail->detailable_type))));
                        $akun = '';
                        if ($detail->akun) {
                            $akun = $detail->akun->nama_akun;
                        } else {
                            $akun = !is_null($detail->detailable->akun) ? $detail->detailable->akun->nama_akun : '';
                        }
                        $details['akun'] = $akun;
                        $details['keterangan'] = $detail->detailable->keterangan ?? '';
                        $this->data[$key]['piutang'][$j]['details'][$x] = $details;
                        $kj++;
                    }
                    $this->data[$key]['piutang'][$j]['total_tagihan'] = $total_tagihan ?? 0;
                    $this->data[$key]['piutang'][$j]['total_retur'] = $retur ?? 0;
                    $this->data[$key]['piutang'][$j]['total_bayar'] = $bayar ?? 0;
                    $this->data[$key]['piutang'][$j]['piutang_final'] = doubleval(str_replace('.', '', $detail->sisa_hutang)) ?? 0;
                    

                    $this->data[$key]['total'] += $this->data[$key]['piutang'][$j]['piutang_final'];
                }
                
            }
        }
        $this->total = 0;
        foreach ($this->data as $key => $value) {
            $this->total += $value['total'];
        }
        $this->total = $this->total <= 0 ? 0 : $this->total;
        $suplier = Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire.utilities.hutang.kartu-hutang', compact('suplier','hutang_pengguna'));
    }
    function exportExcel()
    {
        return Excel::download(new Hutang($this->mulaiId, $this->selesaiId, $this->spId), 'test.xlsx');
    }
    function updatedMulaiId(){
        $this->total = 0;
    }
    function updatedSelesaiId(){
        $this->total = 0;
    }
}
