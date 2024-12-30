<?php

namespace App\Http\Controllers\utilities\produk;

use App\Exports\SetHargaExport;
use App\Models\SetHarga;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class PriceListController extends Controller
{
    public $search = '';
    public $kelompokId;
    public $golonganId;
    public $produsenId;
    public $order;

    public function index()
    {
        return view('utilities.laporan.produk.price-list-produk.price-list-produk', [
            'title' => 'utilities',

        ]);
    }
    public function cetak_pdf(Request $request)
    {
        $q = SetHarga::select('id_perusahaan', 'id_produk', 'id_kelompok', 'id_set', 'satuan', DB::raw('max(created_at) as created'))
            ->groupBy('satuan')
            ->groupBy('id_set')
            ->groupBy('id_kelompok')
            ->groupBy('id_produk')
            ->groupBy('id_perusahaan');

        $setharga = SetHarga::when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
            ->when($request->kelompokId, function ($query) use ($request) {
                $query->where('set_harga.id_kelompok', $request->kelompokId);
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            })
            ->when($request->golonganId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->golonganId);
                });
            })
            ->whereNotNull('sumber')
            ->when($request->kelompokId, function ($query) use ($request) {
                $query->where('set_harga.id_kelompok', $request->kelompokId);
            })
            ->when($request->golonganId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->golonganId);
                });
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            });


        if ($request->order == 3) {
        } elseif ($request->order == 2) {
            $setharga->joinSub($q, 'subquery', function ($join) {
                $join
                    ->on('set_harga.satuan', '=', 'subquery.satuan')
                    ->on('set_harga.id_set', '=', 'subquery.id_set')
                    ->on('set_harga.id_kelompok', '=', 'subquery.id_kelompok')
                    ->on('set_harga.id_produk', '=', 'subquery.id_produk')
                    ->on('set_harga.id_perusahaan', '=', 'subquery.id_perusahaan')
                    ->on('set_harga.created_at', '=', 'subquery.created');
            })->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        } elseif ($request->order == 1) {
            $setharga->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        }
        if ($request->order == 2) {
            $setharga->latest();
        } elseif ($this->order == 1) {
            $setharga->orderBy('created_at', 'asc');
        }
        $setharga = $setharga->with('profile')
            ->get();

        $pdf = PDF::loadView('pdf.utilities.produk.price-list-produk.pdf', [
            'setharga' => $setharga,
        ]);

        return $pdf->stream('price-list-produk.pdf');
    }

    public function cetak_excel(Request $request)
    {
        $q = SetHarga::select('id_perusahaan', 'id_produk', 'id_kelompok', 'id_set', 'satuan', DB::raw('max(created_at) as created'))
            ->groupBy('satuan')
            ->groupBy('id_set')
            ->groupBy('id_kelompok')
            ->groupBy('id_produk')
            ->groupBy('id_perusahaan');

        $setharga = SetHarga::when($request->search, function ($query) use ($request) {
            $query->whereHas('produk', function ($query) use ($request) {
                $query->where('nama_obat_barang', 'like', '%' . $request->search . '%');
            });
        })
            ->when($request->kelompokId, function ($query) use ($request) {
                $query->where('set_harga.id_kelompok', $request->kelompokId);
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            })
            ->when($request->golonganId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->golonganId);
                });
            })
            ->whereNotNull('sumber')
            ->when($request->kelompokId, function ($query) use ($request) {
                $query->where('set_harga.id_kelompok', $request->kelompokId);
            })
            ->when($request->golonganId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('golongan', $request->golonganId);
                });
            })
            ->when($request->produsenId, function ($query) use ($request) {
                $query->whereHas('produk', function ($query) use ($request) {
                    $query->where('produsen', $request->produsenId);
                });
            });

        if ($request->order == 3) {
        } elseif ($request->order == 2) {
            $setharga->joinSub($q, 'subquery', function ($join) {
                $join
                    ->on('set_harga.satuan', '=', 'subquery.satuan')
                    ->on('set_harga.id_set', '=', 'subquery.id_set')
                    ->on('set_harga.id_kelompok', '=', 'subquery.id_kelompok')
                    ->on('set_harga.id_produk', '=', 'subquery.id_produk')
                    ->on('set_harga.id_perusahaan', '=', 'subquery.id_perusahaan')
                    ->on('set_harga.created_at', '=', 'subquery.created');
            })->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        } elseif ($request->order == 1) {
            $setharga->groupBy('set_harga.satuan')
                ->groupBy('set_harga.id_set')
                ->groupBy('set_harga.id_kelompok')
                ->groupBy('set_harga.id_produk')
                ->groupBy('set_harga.id_perusahaan');
        }

        if ($request->order == 2) {
            $setharga->latest();
        } elseif ($request->order == 1) {
            $setharga->orderBy('created_at', 'asc');
        }

        $setharga = $setharga->with('profile')->get();

        // Export to Excel
        return Excel::download(new SetHargaExport($setharga), 'price-list-produk.xlsx');
    }
}
