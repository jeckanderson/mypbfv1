@php
    use App\Models\TargetProduk;
    use App\Models\HistoryStok;
@endphp
<?php
if (!function_exists('angkaBulanIndo')) {
    function angkaBulanIndo($bulan)
    {
        $bulanIndo = [
            'januari' => 1,
            'februari' => 2,
            'maret' => 3,
            'april' => 4,
            'mei' => 5,
            'juni' => 6,
            'juli' => 7,
            'agustus' => 8,
            'september' => 9,
            'oktober' => 10,
            'november' => 11,
            'desember' => 12,
        ];

        $bulan = strtolower($bulan);

        return $bulanIndo[$bulan] ?? null;
    }
}
?>

<div id="{{ $id_modal }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="rounded-lg modal-dialog modal-xl">
        <form action="{{ route($route) }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="p-10 modal-body">
                    <div class="preview">
                        <div class="flex w-full gap-3">
                            <div data-tw-merge class="items-center block mt-3 sm:flex">
                                <h1 class="text-lg font-bold">Edit Target Produk tahun {{ $targetProduk->tahun }} bulan
                                    {{ $targetProduk->bulan }}
                                </h1>
                            </div>
                        </div>
                        <input type="hidden" value="{{ $targetProduk->tahun }}" name="tahun">
                        <input type="hidden" value="{{ $targetProduk->bulan }}" name="bulan">
                        <div class="overflow-auto">
                            <table class="table mt-3">
                                <thead class="font-bold">
                                    <tr>
                                        <td class="border border-slate-600 whitespace-nowrap">Barcode</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Nama Produk</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Stok</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Satuan Terkecil</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Status Aktif</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Tipe</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Target</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Penjualan (A)</td>
                                        <td class="border border-slate-600 whitespace-nowrap">Retur Penjualan (B)</td>
                                        <td class="border border-slate-600 whitespace-nowrap">(A-B)</td>
                                        <td class="border border-slate-600 whitespace-nowrap">%</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (TargetProduk::where('id_perusahaan', Auth::user()->id_perusahaan)->where('tahun', $targetProduk->tahun)->where('bulan', $targetProduk->bulan)->get() as $target)
                                        @php
                                            $histori = HistoryStok::where('id_produk', $target->id_produk);
                                            $stok = $histori->sum('stok_masuk') - $histori->sum('stok_keluar');

                                            $year = $targetTahun ?? '';
                                            $month = angkaBulanIndo($targetBulan) ?? '';

                                            $penjualan = $target->produkPenjualan
                                                ->filter(function ($item) use ($year, $month) {
                                                    return $item->created_at->year == $year &&
                                                        $item->created_at->month == $month;
                                                })
                                                ->count();

                                            $retur = $target->produkReturPenjualan
                                                ->filter(function ($item) use ($year, $month) {
                                                    return $item->created_at->year == $year &&
                                                        $item->created_at->month == $month;
                                                })
                                                ->count();
                                            $hasil = $penjualan - $retur;
                                            if ($hasil != 0) {
                                                $persentase = ($hasil / $target->target) * 100;
                                            } else {
                                                $persentase = 0;
                                            }
                                        @endphp
                                        <tr>
                                            <td class="border border-slate-600">
                                                {{ $target->obatBarang->barcode_produk }}
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $target->obatBarang->nama_obat_barang }}
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $stok }}
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $target->obatBarang->satuanTerkecil->satuan }}
                                            </td>
                                            <td class="border border-slate-600">
                                                {{ $target->obatBarang->status == 1 ? 'Aktif' : 'Non Aktif' }}
                                            </td>
                                            <td class="border border-slate-600">{{ $target->obatBarang->tipe }}
                                            </td>
                                            <td class="border border-slate-600">
                                                <input data-tw-merge id="horizontal-form-1" type="number"
                                                    placeholder="" name="target[{{ $loop->index }}][target_produk]"
                                                    value="{{ $target->target }}" {{ $lihat ? 'readonly' : '' }}
                                                    class="w-32 disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                                                <input type="hidden" name="target[{{ $loop->index }}][id_produk]"
                                                    value="{{ $target->obatBarang->id }}">
                                            </td>
                                            <td class="border border-slate-600">{{ $penjualan }}</td>
                                            <td class="border border-slate-600">{{ $retur }}</td>
                                            <td class="border border-slate-600">{{ $hasil }}</td>
                                            <td class="border border-slate-600 whitespace-nowrap">
                                                {{ number_format($persentase, 2, ',', '.') }} %
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                @if (!$lihat)
                    <div class="modal-footer">
                        <button class="mt-5 btn btn-primary" type="submit" name="submit"> Simpan </button>
                        <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal
                        </button>

                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
