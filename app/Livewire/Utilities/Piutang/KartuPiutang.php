<?php

namespace App\Livewire\Utilities\Piutang;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Exports\Kartu\Hutang;
use App\Exports\Kartu\Piutang;
use App\Models\ReturPenjualan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class KartuPiutang extends Component
{
    use WithPagination;
    public $mulaiId;
    public $selesaiId, $total = 0;

    public $pelangganId;

    public $search = '';

    public $data;
    public function mount()
    {
        $this->mulaiId = date('Y-m-01');
        $this->selesaiId = date('Y-m-t');
    }
    public function render()
    {

        $pelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->total = 0;
        // $hutang_pengguna = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)
        //     // Filter berdasarkan pelanggan jika pelangganId ada
        //     ->when($this->pelangganId, function ($q) {
        //         $q->where('id', $this->pelangganId);
        //     })
        //     // Filter berdasarkan range tanggal piutang
        //     ->when($this->selesaiId && $this->mulaiId, function ($query) {
        //         $query->whereHas('piutang', function ($subQuery) {
        //             $subQuery->whereBetween('created_at', [$this->mulaiId, $this->selesaiId]);
        //         });
        //     })
        //     // Filter berdasarkan input pencarian pada nomor faktur
        //     ->when($this->search, function ($query) {
        //         $query->whereHas('piutang', function ($subQuery) {
        //             // Filter berdasarkan nomor faktur
        //             $subQuery->whereHas('sourceable', function ($subSubQuery) {
        //                 $subSubQuery->where('no_faktur', 'like', '%' . $this->search . '%');
        //             });
        //         });
        //     })
        //     ->with(['piutang' => function ($q) {
        //         return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        //     }, 'piutang.sourceable.piutang_pengguna', 'piutang.sourceable.piutang_pengguna.detailable'])
        //     ->get();

        $hutang_pengguna = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)
            // Filter by pelanggan if pelangganId exists
            ->when($this->pelangganId, function ($query) {
                $query->where('id', $this->pelangganId);
            })
            // Filter by date range on piutang
            ->when($this->mulaiId && $this->selesaiId, function ($query) {
                $query->whereHas('piutang', function ($subQuery) {
                    // $subQuery->where('sumber','like','%'.$this->search.'%');
                    $subQuery->whereHasMorph('sourceable', '*', function ($subSubQuery) {
                        // Search by 'no_faktur' on the polymorphic relationship
                        $subSubQuery->whereRaw("DATE(tgl_faktur) BETWEEN ? AND ?", [$this->mulaiId, $this->selesaiId]);
                    });
                });
            })
            // Eager load relationships without grouping inside with()
            ->with([
                'piutang' => function ($q) {
                    return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
                },
                'piutang.sourceable.piutang_pengguna',
                'piutang.sourceable.piutang_pengguna.detailable'
            ])
            ->paginate(10);
        $this->data = [];
        $sum_total_tagihan = 0;
        $sum_total_bayar = 0;
        $sum_total_retur = 0;
        $sum_total_sisa_hutang = 0;
        foreach ($hutang_pengguna as $key => $pengguna) {

            foreach ($pengguna->piutang as $i => $c) {
                // if (!is_null($c->sourceable)) {
                //     $w = 0;
                //     foreach ($c->sourceable->piutang_pengguna as $d) {
                //         $w = str_replace('.', '', $d->sisa_hutang);
                //     }
                //     $this->total += $w;
                // }
                $this->data[$key]['name'] = $pengguna->nama;

                $k = 1;
                $this->data[$key]['total'] = 0;
                $piutangss = $pengguna->piutang()
                    ->with(['sourceable' => function ($query) {
                        $query->selectRaw('*, COUNT(*) as total')
                            ->groupBy('no_faktur');
                    }, 'sourceable.piutang_pengguna', 'sourceable.piutang_pengguna.detailable'])
                    ->when($this->mulaiId && $this->selesaiId, function ($query) {
                        $query->whereHas('sourceable', function ($subQuery) {
                            $subQuery->whereRaw("DATE(tgl_faktur) BETWEEN ? AND ?", [$this->mulaiId, $this->selesaiId]);
                        });
                    })
                    ->groupBy('sourceable_type','sourceable_id')
                    ->get();
                foreach ($piutangss as $j => $piutang) {
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
                    foreach ($piutang->sourceable->piutang_pengguna as $x => $detail) {
                        if ($detail->detailable_type != \App\Models\ReturPenjualan::class) {
                            $bayar += str_replace('.', '', $detail->nominal_bayar);
                        }

                        $sisa_hutang += str_replace('.', '', $detail->sisa_hutang);
                        $sum_total_sisa_hutang += str_replace(
                            '.',
                            '',
                            $detail->sisa_hutang,
                        );
                        if ($detail->detailable_type == \App\Models\ReturPenjualan::class) {
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
                        $details['retur'] = $detail->detailable_type == \App\Models\ReturPenjualan::class ? doubleval(str_replace('.', '', $detail->detailable->total)) : 0;
                        $details['bayar_retur'] = $detail->detailable_type != \App\Models\ReturPenjualan::class ? doubleval(str_replace('.', '', $detail->nominal_bayar)) : 0;
                        $details['sisa_hutang'] = doubleval(str_replace('.', '', $detail->sisa_hutang));
                        $details['uang_retur'] = $detail->detailable_type == \App\Models\ReturPenjualan::class ? doubleval(str_replace('.', '', $detail->detailable->uang_retur)) : 0;
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
                    $this->data[$key]['piutang'][$j]['piutang_final'] = doubleval($detail->sisa_hutang) ?? 0;

                    $this->data[$key]['total'] += $this->data[$key]['piutang'][$j]['piutang_final'];
                }
            }
        }
        $this->total = 0;
        foreach ($this->data as $key => $value) {
            $this->total += $value['total'];
        }
        $this->total = $this->total <= 0 ? 0 : $this->total;
        // dd($this->data);
        return view('livewire..utilities.piutang.kartu-piutang', compact('pelanggan', 'hutang_pengguna'));
    }

    function exportExcel()
    {
        return Excel::download(new Piutang($this->mulaiId, $this->selesaiId, $this->pelangganId), 'test.xlsx');
    }
    public function exportPdf()
    {
        $hutang_pengguna = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->has('piutang')->with(['piutang' => function ($q) {
            return $q->groupBy('sourceable_type')->groupBy('sourceable_id');
        }, 'piutang.sourceable' => function ($q) {
            $q->when($this->search, function ($qq) {
                $qq->where('no_faktur', 'LIKE', '%' . $this->search . '%');
            });
        }, 'piutang.sourceable.piutang_pengguna', 'piutang.sourceable.piutang_pengguna.detailable'])->when($this->pelangganId, function ($q) {
            $q->where('id', $this->pelangganId);
        })
            ->when($this->selesaiId && $this->mulaiId, function ($query) {
                if ($this->mulaiId == $this->selesaiId) {
                    $query->whereHas('piutang', function ($query) {
                        $query->whereDate('created_at', $this->mulaiId);
                    });
                } else {
                    $finalEndDate = Carbon::createFromFormat('Y-m-d', $this->selesaiId)->endOfDay();
                    $finalStartDate = Carbon::createFromFormat('Y-m-d', $this->mulaiId)->startOfDay();
                    $query->whereHas('piutang', function ($query) use ($finalStartDate, $finalEndDate) {
                        $query->whereBetween('created_at', [$finalStartDate, $finalEndDate]);
                    });
                }
            })
            ->get();
        $pdf = Pdf::loadView('excel.kartu_piutang', compact('hutang_pengguna'));
        return $pdf->stream('kartu-piutang');
    }
}
