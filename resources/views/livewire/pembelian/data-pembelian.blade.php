<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\TerimaBarang;
    @endphp
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

        body {
            font-family: Arial, sans-serif;
            margin: 5px;
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
    <div class="flex flex-wrap items-center col-span-12 gap-2 mt-0 intro-y sm:flex-nowrap">
        <div class="flex justify-end gap-2 mt-6">
            @can('tambah_pembelian')
                <a href="/tambah-pembelian"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i>
                        Tambah</button>
                </a>
            @endcan
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-5 form-control box" placeholder="Search No. Faktur ..."
                    wire:model.live.debounce.150ms='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <div class="flex justify-end gap-2 mt-6">
            {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                Status
            </label> --}}
            <select data-tw-merge aria-label="Default select example" class="form-control sm:w-36"
                wire:model.live='statusKredit'>
                <option value="">- Status Bayar -</option>
                <option value="0">Tunai</option>
                <option value="1">Kredit</option>
            </select>
        </div>
        <div class="flex justify-end mt-6">
            <div data-tw-merge class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 gap-2">
                    <input wire:model.live="tanggalMulai" id="tanggalMulai" type="date"
                        class="w-full sm:w-40 text-sm rounded-md shadow-sm border-slate-200" />
                    <span class="text-sm mt-2 sm:mt-0">s.d</span>
                    <input wire:model.live="tanggalAkhir" id="tanggalAkhir" type="date"
                        class="w-full sm:w-40 text-sm rounded-md shadow-sm border-slate-200" />
                    <button onclick="location.reload()" class="btn btn-secondary flex items-center space-x-1"
                        wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4"></i>
                        <span>Reload</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible box">
        <div class="mt-2 overflow-auto">
            <table class="table mt-2">
                <thead>
                    <tr class="header-gray">
                        <th rowspan="2" class="border border-slate-600">No</th>
                        <th rowspan="2" class="border border-slate-600">No Reff</th>
                        <th colspan="7" class="border border-slate-600">Faktur</th>
                        <th colspan="2" class="border border-slate-600">Surat Pesanan</th>
                        <th colspan="5" class="border border-slate-600">Pajak</th>
                        <th rowspan="2" class="border border-slate-600">Total</th>
                        <th rowspan="2" class="border border-slate-600">Actions</th>
                    </tr>
                    <tr class="header-gray">
                        <th class="border border-slate-600">No. Faktur</th>
                        <th class="border w-96 border-slate-600">Tgl Faktur</th>
                        <th class="border border-slate-600">Tgl Input</th>
                        <th class="border border-slate-600">Tgl JT</th>
                        <th class="border border-slate-600">Suppier</th>
                        <th class="border border-slate-600">Status PPN</th>
                        <th class="border border-slate-600">Status Bayar</th>
                        <th class="border border-slate-600">No. SP</th>
                        <th class="border border-slate-600">Tgl. SP</th>
                        <th class="border border-slate-600">No. Seri</th>
                        <th class="border border-slate-600">Tanggal</th>
                        <th class="border border-slate-600">Kompensasi</th>
                        <th class="border border-slate-600">DPP</th>
                        <th class="border border-slate-600">PPN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totals = 0;
                    @endphp
                    @forelse ($pembelians as $pembelian)
                        @php
                            $totals += $pembelian->total_tagihan;
                        @endphp
                        <tr>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $pembelian->no_reff }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $pembelian->no_faktur }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->tgl_faktur->format('d-m-Y') }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->tgl_input->format('d-m-Y') }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->tempo_kredit->format('d-m-Y') ?? '-' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->getSuplier->nama_suplier }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->inc_ppn == 0 ? 'Non Inc PPN' : 'Inc PPN' }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->kredit == 1 ? 'Kredit' : 'Tunai' }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $pembelian->sp->no_sp }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->sp->tgl_sp->format('d-m-Y') }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">{{ $pembelian->no_faktur_pajak }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->tgl_faktur_pajak != '-' ? date('d-m-Y', strtotime($pembelian->tgl_faktur_pajak)) : '-' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ $pembelian->kompensasi_pajak != '-' ? date('d-m-Y', strtotime($pembelian->kompensasi_pajak)) : '-' }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ number_format($pembelian->dpp, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ number_format($pembelian->ppn, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                {{ number_format($pembelian->total_tagihan, 0, ',', '.') }}</td>
                            <td class="border border-slate-600 whitespace-nowrap">
                                <div class="flex gap-2">
                                    @can('aksi_pembelian')
                                        <a href="/lihat-pembelian/{{ $pembelian->id }}">
                                            <button class="border-none btn btn-sm btn-outline-primary">Detail</button>
                                        </a>
                                        {{-- ppn button --}}
                                        <button class="border-none btn btn-sm btn-outline-primary" data-tw-toggle="modal"
                                            data-tw-target="#edit-modal{{ $pembelian->id }}">No. Pajak</button>
                                        <a href="/cetak-pembelian-pdf/{{ $pembelian->id }}">
                                            <button class="border-none btn btn-sm btn-outline-primary">Print</button>
                                        </a>

                                        @if (!TerimaBarang::where('id_pembelian', $pembelian->id)->exists())
                                            <button class="border-none btn btn-sm btn-outline-danger"
                                                wire:confirm="Apakah anda yakin akan menghapus data pembelian?"
                                                wire:click='hapusPembelian({{ $pembelian->id }})'>Delete</button>
                                        @endif
                                    @endcan
                                </div>
                            </td>
                            <div id="edit-modal{{ $pembelian->id }}" class="modal" tabindex="-1"
                                aria-hidden="true">
                                <div class="rounded-lg modal-dialog modal-lg">
                                    @livewire('pembelian.edit-tax', ['pembelianId' => $pembelian->id])
                                </div>
                            </div>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="18" class="font-bold text-center border text-pending border-slate-600">
                                Belum
                                ada data
                                tersedia</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="16" class="font-bold text-center border border-slate-600">Total</td>
                        <td colspan="17" class="font-bold border text-centre border-slate-600">
                            {{ number_format($totals, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>
