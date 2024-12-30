<div>
    @php
        use App\Models\Penjualan;
    @endphp
    <div class="grid grid-cols-12 gap-2 mt-8">
        <div class="col-span-6 md:col-span-3">
            <div class="flex justify-between gap-1">
                <div class="flex flex-col sm:flex-row items-center">
                    <div class="flex items-center gap-2">
                        <input id="tanggalMulai" type="date"
                            class="w-full text-sm rounded-md shadow-sm border-slate-200" wire:model.live='mulaiId' />
                        <p class="w-16 text-center">s.d</p>
                        <input id="tanggalAkhir" type="date"
                            class="w-full text-sm rounded-md shadow-sm border-slate-200" wire:model.live='selesaiId' />
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row mr-auto">
                    <select data-tw-merge id="pelanggan" aria-label="Default select example"
                        wire:model.live="pelangganId" class="w-auto ml-2 form-control">
                        <option value=>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col sm:flex-row items-center mr-auto">
                    <select data-tw-merge id="sales" aria-label="Default select example" wire:model.live="salesId"
                        class="w-auto ml-2 form-control">
                        <option value=>- Pilih sales -</option>
                        @foreach ($sales as $item)
                            <option value="{{ $item->pegawai_sales->id }}">{{ $item->pegawai_sales->nama_pegawai }}
                            </option>
                        @endforeach
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>
            </div>

        </div>
        <!-- END: Data List -->
    </div>

    @forelse ($penjualan as $item)

        <div class="mt-2 p-3 border rounded-md bg-white w-full">
            <p class="font-bold text-pending">{{ $item->nama }}</p>
        </div>
        <div class="mt-2 box">
            <div class="overflow-auto">
                <table class="table mt-2">
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
                            <th rowspan="2" class="border border-slate-600">No</th>
                            <th rowspan="2" class="border border-slate-600">Tanggal</th>
                            <th rowspan="2" class="border border-slate-600">No. Faktur</th>
                            <th rowspan="2" class="border border-slate-600">Sales</th>
                            <th rowspan="2" class="border border-slate-600">Sub Total</th>
                            {{-- <th rowspan="2" class="border border-slate-600">Disc %</th>
                            <th rowspan="2" class="border border-slate-600">Disc Nominal</th> --}}
                            <th rowspan="2" class="border border-slate-600">DPP </th>
                            <th rowspan="2" class="border border-slate-600">PPN</th>
                            <th rowspan="2" class="border border-slate-600">Total</th>
                            <th rowspan="2" class="border border-slate-600">Biaya 1</th>
                            <th rowspan="2" class="border border-slate-600">Biaya 2</th>
                            <th rowspan="2" class="border border-slate-600">Total Tagihan</th>
                            <th rowspan="2" class="border border-slate-600">Jumlah Bayar</th>
                            <th rowspan="2" class="border border-slate-600">Piutang</th>
                            <th rowspan="2" class="border border-slate-600">Pembayaran</th>
                        </tr>

                    </thead>
                    @php
                        $total_dpp = 0;
                        $total_ppn = 0;
                        $total = 0;
                        $total_biaya1 = 0;
                        $total_biaya2 = 0;
                        $total_tagihan = 0;
                        $total_jumlah_bayar = 0;
                        $total_hutang = 0;
                    @endphp
                    <tbody>
                        @forelse ($item->penjualan()->when($selesaiId && $mulaiId, function ($query) use($mulaiId, $selesaiId) {
                            $query->whereBetween(\Illuminate\Support\Facades\DB::raw('DATE(tgl_faktur)'), [$mulaiId, $selesaiId]);
                        })->get() as $penjualans)
                            @php
                                $total_dpp += $penjualans->dpp;
                                $total_ppn += $penjualans->ppn;
                                $total_biaya1 += $penjualans->biaya1;
                                $total_biaya2 += $penjualans->biaya2;
                                $total_tagihan += $penjualans->total_tagihan;
                                $total_hutang += $penjualans->total_hutang;
                                $total_jumlah_bayar += $penjualans->umlah_bayar;
                                $total += $total_dpp + $total_ppn;
                            @endphp
                            <tr class="text-center intro-x">
                                <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                <td class="border border-slate-600">
                                    {{ date('d-m-Y', strtotime($penjualans->tgl_faktur)) }}</td>
                                <td class="border border-slate-600">{{ $penjualans->no_faktur }}</td>

                                <td class="border border-slate-600">{{ $penjualans->getSales->nama_pegawai }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format($penjualans->subtotal, 0, ',', '.') }}</td>
                                {{-- <td class="border border-slate-600">
                                    {{ number_format($penjualans->diskon, 0, ',', '.') }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format($penjualans->hasil_diskon, 0, ',', '.') }}</td> --}}
                                <td class="border border-slate-600">{{ number_format($penjualans->dpp, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-600">{{ number_format($penjualans->ppn, 0, ',', '.') }}
                                </td>
                                <td class="border border-slate-600">
                                    {{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>

                                <td class="border border-slate-600">
                                    {{ $penjualans->biaya1 }}</td>
                                <td class="border border-slate-600">
                                    {{ $penjualans->biaya2 }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format($penjualans->total_tagihan, 0, ',', '.') }}</td>
                                <td class="border border-slate-600">
                                    {{ $penjualans->jumlah_bayar }}</td>
                                <td class="border border-slate-600">
                                    {{ number_format($penjualans->total_hutang, 0, ',', '.') }}</td>
                                <td class="border border-slate-600">
                                    {{ $penjualans->kredit == 0 ? 'Cash' : 'Kredit' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="font-bold text-center text-pending border border-slate-600" colspan="16">
                                    Belum ada
                                    data
                                    tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="font-bold text-center">
                            <td colspan="5" class="border border-slate-600">Total</td>


                            <td class="border border-slate-600">
                                {{ number_format($total_dpp, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total_ppn, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total, 0, ',', '.') }}
                            </td>
                            <td class="border border-slate-600">
                                {{ number_format($total_biaya1, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total_biaya2, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total_tagihan, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total_jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="border border-slate-600">
                                {{ number_format($total_hutang, 0, ',', '.') }}</td>
                            <td colspan="5" class="border border-slate-600"></td>
                        </tr>
                    </tfoot>

                </table>
            </div>

        </div>
    @empty
        <div class="p-5 mt-2 box">
            <p class="font-bold text-pending text-center">Belum ada data tersedia</p>
        </div>
    @endforelse
    <div class="mt-2">
        {{ $penjualan->links('pagination::tailwind') }}
    </div>
</div>
<script>
    function validateDateInputs() {
        var tanggalDari = document.getElementById('tanggal-dari').value;
        var tanggalSampai = document.getElementById('tanggal-sampai').value;

        if (!tanggalDari || !tanggalSampai) {
            alert('Harap isi kedua tanggal sebelum mencetak PDF!');
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        var printPdfButton = document.getElementById('print-pdf-button');
        printPdfButton.addEventListener('click', function(event) {
            if (!validateDateInputs()) {
                event.preventDefault(); // Prevent the default action (printing PDF) if validation fails
            }
        });
    });
</script>
