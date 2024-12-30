<div>
    @php
        use App\Models\AkunAkutansi;
        use App\Models\Jurnal;
    @endphp
    <div class="grid grid-cols-12 gap-6 mt-5">
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <div class="justify-between gap-3 sm:flex">
                <div class="relative w-56 text-slate-500 ">
                    <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search..."
                        wire:model.live.debounce.350ms="search">
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
                <div data-tw-merge class="flex items-center block gap-2 mr-auto">
                    <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-28">
                        Tampilkan
                    </label>
                    <select data-tw-merge aria-label="Default select example" class="form-control"
                        wire:model.live="perPage">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <p class="mt-2 mb-2">Halaman</p>
                </div>
                <div class="">
                    <div class="flex gap-2 mb-2 mr-auto overflow-auto sm:mb-0">
                        {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-20">
                            Periode
                        </label> --}}
                        <input wire:model.live="tanggalMulai" id="tanggalMulai" type="date"
                            class="w-full text-sm rounded-md shadow-sm border-slate-200" />
                        <p class="w-full mt-3">s/d</p>
                        <input wire:model.live="tanggalAkhir" id="tanggalAkhir" type="date"
                            class="w-full text-sm rounded-md shadow-sm border-slate-200" />
                    </div>
                </div>
                <a
                    href="{{ route('cetak.buku-besar', ['tanggalMulai' => $tanggalMulai, 'tanggalAkhir' => $tanggalAkhir]) }}">
                    <button class="btn btn-facebook">
                        <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
                    </button>
                </a>
            </div>
            {{-- start Box --}}
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
                                @forelse (Jurnal::where('kode_akun', $akun->kode)->where('id_perusahaan', Auth::user()->id_perusahaan)->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir])->get() as $jurnal)
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
                                        <td class="text-center border border-slate-600" colspan="6">Belum ada data
                                            tersedia</td>
                                    </tr>
                                @endforelse
                                @php
                                    $totalDebet = round(
                                        Jurnal::where('kode_akun', $akun->kode)
                                            ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                            ->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir])
                                            ->sum('debet'),
                                    );
                                    $totalKredit = round(
                                        Jurnal::where('kode_akun', $akun->kode)
                                            ->where('id_perusahaan', Auth::user()->id_perusahaan)
                                            ->whereBetween('created_at', [$this->tanggalMulai, $this->tanggalAkhir])
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
                    <h1 class="font-bold text-center">Belum ada data tersedia</h1>
                </div>
            @endforelse
            <div class="flex justify-center mt-4">
                {{ $akuns->links() }}
            </div>
        </div>
    </div>
</div>
