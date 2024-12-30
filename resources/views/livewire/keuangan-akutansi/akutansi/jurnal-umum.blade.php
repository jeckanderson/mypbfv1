<div>
    @php
        use App\Models\Jurnal;
    @endphp
    <div class="flex justify-between gap-2 mt-8 mb-3 items-center">
        <!-- Search Box -->
        <div class="relative w-56 text-slate-500">
            <input type="text" class="w-full pr-10 form-control box" placeholder="Search..."
                wire:model.live.debounce.150ms='cariNoReff'>
            <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
        </div>

        <!-- Date Range Inputs -->
        <div class="flex items-center gap-2">
            <input wire:model.live="tanggalMulai" id="tanggalMulai" type="date"
                class="w-36 text-sm rounded-md shadow-sm border-slate-200" />
            <p class="text-sm mt-1">s.d</p>
            <input wire:model.live="tanggalAkhir" id="tanggalAkhir" type="date"
                class="w-36 text-sm rounded-md shadow-sm border-slate-200" />
        </div>
        <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
            <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
        </button>

        <!-- Print Button -->
        <a href="{{ route('cetak-jurnal-umum', ['tanggalMulai' => $tanggalMulai, 'tanggalAkhir' => $tanggalAkhir]) }}">
            <button class="btn btn-facebook" wire:ignore><i data-feather="printer"
                    class="w-4 h-4 mr-1"></i>Print</button>
        </a>
    </div>

    @forelse ($jurnals->groupBy('no_reff')->orderBy('created_at','desc')->paginate(10) as $get)
        <div class="mt-2 box">
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
                            <th class="border border-slate-600" rowspan="2">No. Reff</th>
                            <th class="border border-slate-600" rowspan="2">Tanggal</th>
                            <th class="border border-slate-600" rowspan="2">Kode Akun</th>
                            <th class="border border-slate-600" rowspan="2">Nama Akun</th>
                            <th class="border border-slate-600" rowspan="2">Keterangan</th>
                            <th class="border border-slate-600" colspan="2">Saldo</th>
                        </tr>
                        <tr class="header-gray">
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->get() as $jurnal)
                            <tr class="text-center">
                                <td class="border border-slate-600">{{ $jurnal->no_reff }}</td>
                                <td class="border border-slate-600">
                                    @if ($jurnal->sumber == 'Hutang Awal' || $jurnal->sumber == 'Piutang Awal' || $jurnal->sumber == 'Stok Awal')
                                        {{ $tglNeraca }}
                                    @elseif($jurnal->sumber == 'Jurnal Akun')
                                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $jurnal->jurnalAkun->tgl_input)->format('d-m-Y') }}
                                    @elseif($jurnal->sumber == 'Mutasi Saldo')
                                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $jurnal->mutasiSaldo->tgl_input)->format('d-m-Y') }}
                                    @else
                                        {{ $jurnal->created_at->format('d-m-Y') }}
                                    @endif
                                </td>
                                <td class="border border-slate-600">{{ $jurnal->kode_akun }}</td>
                                <td class="border border-slate-600">{{ $jurnal->akun->nama_akun }}</td>
                                <td class="border border-slate-600">{{ $jurnal->keterangan }}</td>
                                <td class="border border-slate-600">
                                    {{ $jurnal->debet != 0 ? number_format(round($jurnal->debet), 0, ',', '.') : '-' }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ $jurnal->kredit != 0 ? number_format(round($jurnal->kredit), 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="font-bold text-center">Total</td>
                            <td class="text-center border border-slate-600">
                                <p class="p-1 font-bold text-white rounded bg-success">
                                    {{ number_format(round(Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->sum('debet')),0,',','.') }}
                                </p>
                            </td>
                            <td class="text-center border border-slate-600">
                                <p class="p-1 font-bold text-white rounded bg-success">
                                    {{ number_format(round(Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan)->where('no_reff', $get->no_reff)->sum('kredit')),0,',','.') }}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="mt-3 box">
            <h3 class="p-5 font-bold text-pending text-center">Belum ada data jurnal tersedia</h3>
        </div>
    @endforelse
    <div class="flex justify-center mt-5">
        {{ $jurnals->orderBy('created_at', 'desc')->paginate(10)->links() }}
    </div>
</div>
