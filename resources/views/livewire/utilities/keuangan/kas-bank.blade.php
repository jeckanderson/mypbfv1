<div>
    @php
        use App\Models\AkunAkutansi;
        use App\Models\Jurnal;
    @endphp
    <div class="grid grid-cols-12 gap-6 mt-5">

        <div class="col-span-6 md:col-span-3">

            <div class="flex items-center mb-3">
                <div class="relative w-56 text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search Nama Akun ..."
                        wire:model.live.debounce.300ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-20">s/d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>

            {{-- <div class="col-span-6 md:col-span-3"style="position: absolute; top: 285px; right:55px;">
                <div class="flex gap-2">
                    <button class="btn btn-success">
                        <span wire:ignore><i data-feather="file-text" class="w-5 h-5 mr-1"></i>Excel</span>
                    </button>
                    <a href="{{ route('cetak_pdf_kas_bank', [
                        'search' => $search,
                        'mulaiId' => $mulaiId,
                        'selesaiId' => $selesaiId,
                    ]) }}"
                        target="_blank" class="btn btn-primary"><span wire:ignore><i data-feather="printer"
                                class="w-5 h-5 mr-1"></i>PDF</span></a>
                </div>
            </div> --}}

            {{-- <div class="col-span-6 md:col-span-3" style="position: absolute; top: 300px; right: 180px;">
                <div class="flex items-center mb-3">
                    <label for="search" class="inline-block mt-2 mb-2 sm:w-20">Cari</label>
                    <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                        class="block w-full rounded-md shadow-sm form-input">
                </div>
            </div> --}}

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>

        </div>
    </div>

    @forelse ($akuns as $akun)
        <div class="p-5 mt-5 box">
            <div class="flex justify-between gap-3 mt-5 mb-3">
                <p class="mr-auto ">Akun : <span class="font-bold">{{ $akun->kode }} -
                        {{ $akun->nama_akun }}</span>
                </p>
            </div>
            <div class="overflow-auto">
                <table class="table">
                    <style>
                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }
                    </style>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }

                        th,
                        td {
                            padding: 3px;
                            text-align: left;
                        }

                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }

                        th {
                            font-weight: bold;
                            text-align: center;
                        }

                        td {
                            font-size: 1em;
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <th class="border border-slate-600">No. Reff</th>
                            <th class="border border-slate-600">Tanggal</th>
                            <th class="border border-slate-600">Keterangan</th>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                            <th class="border border-slate-600">Saldo Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (Jurnal::where('kode_akun', $akun->kode)->where('id_perusahaan', Auth::user()->id_perusahaan)->whereBetween('created_at', [ \Carbon\Carbon::parse($this->mulaiId)->startOfDay(),
                            \Carbon\Carbon::parse($this->selesaiId)->endOfDay()])->get() as $jurnal)
                            <tr class="text-center">
                                <td class="border border-slate-600">{{ $jurnal->no_reff }}</td>
                                <td class="border border-slate-600">{{ $jurnal->created_at->format('d-m-Y') }}
                                </td>
                                <td class="border border-slate-600">{{ $jurnal->keterangan }}</td>
                                <td class="border border-slate-600">
                                    {{ $jurnal->debet != 0 ? number_format(round($jurnal->debet), 0, ',', '.') : '-' }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ $jurnal->kredit != 0 ? number_format(round($jurnal->kredit), 0, ',', '.') : '-' }}
                                </td>
                                <td class="border border-slate-600">
                                    -
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="6">
                                    Belum ada data
                                    tersedia</td>
                            </tr>
                        @endforelse
                        @php
                            $totalDebet = round(
                                Jurnal::where('kode_akun', $akun->kode)
                                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                    ->whereBetween('created_at', [$this->mulaiId, $this->selesaiId])
                                    ->get()
                                    ->sum('debet'),
                            );
                            $totalKredit = round(
                                Jurnal::where('kode_akun', $akun->kode)
                                    ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                    ->whereBetween('created_at', [$this->mulaiId, $this->selesaiId])
                                    ->get()
                                    ->sum('kredit'),
                            );
                            $saldo = $totalDebet - $totalKredit;
                        @endphp

                        <tr class="font-bold text-center">
                            <td class="font-bold text-center border border-slate-600" colspan="3">Total</td>
                            <td class="border border-slate-600">
                                {{ number_format($totalDebet, 0, ',', '.') ?? '-' }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($totalKredit, 0, ',', '.') ?? '-' }}</td>
                            <td class="border border-slate-600">
                                @if (in_array($akun->jenis_akun, ['Aktiva', 'HPP', 'Biaya', 'Biaya Lain']))
                                    {{ number_format($saldo, 0, ',', '.') ?? '-' }}
                                @elseif (in_array($akun->jenis_akun, ['Kewajiban', 'Modal', 'Pendapatan', 'Pendapatan Lain']))
                                    {{ number_format(-$saldo, 0, ',', '.') ?? '-' }}
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="p-5 mt-5 box">
            <h1 class="font-bold text-center text-pending">Belum ada data tersedia</h1>
        </div>
    @endforelse
    <div class="flex justify-center mt-4">
        {{ $akuns->links() }}
    </div>
</div>
<!-- END: Data List -->
</div>
</div>
