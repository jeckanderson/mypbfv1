<div>
    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- BEGIN: Data List -->
        <div class="col-span-6 md:col-span-3">
            <div class="flex items-center mb-3">
                {{-- masukan disini --}}
                <div class="col-span-6 md:col-span-3">
                    <div class="relative w-56 text-slate-500">
                        <input type="text" class="w-56 pr-10 form-control cari box" placeholder="Search No. Faktur..."
                            wire:model.live.debounce.300ms="search">
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                    </div>
                </div>

                <div class="ml-2">
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;" class="form-input rounded-md" />
                </div>
                <label for="tanggal-sampai" class="inline-block mt-2 mb-2 ml-2 sm:w-full">s.d</label>
                <div class="ml-2">
                    <input id="tanggal-sampai" wire:model.lazy="selesaiId" name="selesaiId" type="date"
                        placeholder="Stok dari master" style="width: 150px;" class="form-input rounded-md" />
                </div>

                <div class="flex items-center mr-auto">
                    <select data-tw-merge id="pelanggan" name="pelanggan" wire:model.live="pelangganId"
                        aria-label="Default select example" class="w-auto ml-2 form-control">
                        <option value=>- Pilih Pelanggan -</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center mr-auto">
                    <select data-tw-merge id="sales"name="sales" wire:model.live="salesId"
                        aria-label="Default select example" class="w-auto ml-2 form-control">
                        <option value=>- Pilih Sales -</option>
                        @foreach ($sales as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_pegawai }}</option>
                        @endforeach
                    </select>
                    <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                        <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                    </button>
                </div>

                {{-- <div class="fixed-corner top-300 right-0 p-2">
                    <div class="flex gap-2">
                        <div class="col-span-6 md:col-span-3">
                            <div class="flex gap-2">
                                <button class="btn btn-success text-white" wire:ignore>
                                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                                </button>
                                <div class="flex gap-2">
                                    <a id="print-pdf-button"
                                        href="{{ route('cetak_pdf_faktur', [
                                            'search' => $search,
                                            'salesId' => $salesId,
                                            'mulaiId' => $mulaiId,
                                            'selesaiId' => $selesaiId,
                                            'pelangganId' => $pelangganId,
                                        ]) }}"
                                        target="_blank" class="btn btn-facebook" wire:ignore><i data-feather="printer"
                                            class="w-4 h-4 mr-1"></i>Print</a>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}


                <div class="text-center" wire:loading wire:target="print">
                    Loading PDF...
                </div>

            </div>

        </div>
        <!-- END: Data List -->
    </div>


    <div class="overflow-auto box">
        <table class="table mt-5">
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
                    <th rowspan="2" class="border border-slate-600">Pelanggan</th>
                    <th rowspan="2" class="border border-slate-600">Sales</th>
                    <th rowspan="2" class="border border-slate-600">DPP </th>
                    <th rowspan="2" class="border border-slate-600">PPN</th>
                    <th rowspan="2" class="border border-slate-600">Total</th>

                </tr>
            </thead>

            <tbody>
                @forelse ($penjualan as $penjualans)
                    <tr class="text-center intro-x">
                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                        <td class="border border-slate-600">{{ $penjualans->tgl_faktur->format('d-m-Y') }}</td>
                        <td class="border border-slate-600">{{ $penjualans->no_faktur }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getPelanggan->nama }}</td>
                        <td class="border border-slate-600">{{ $penjualans->getSales->nama_pegawai }}</td>
                        <td class="border border-slate-600">{{ number_format($penjualans->dpp, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">{{ number_format($penjualans->ppn, 0, ',', '.') }}</td>
                        <td class="border border-slate-600">
                            {{ number_format($penjualans->ppn + $penjualans->dpp, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="font-bold text-center text-pending border border-slate-600" colspan="9">Belum ada
                            data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="font-bold text-center">
                    <td colspan="5" class="border border-slate-600">Total</td>
                    <td class="border border-slate-600">{{ number_format($penjualan->sum('dpp'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">{{ number_format($penjualan->sum('ppn'), 0, ',', '.') }}</td>
                    <td class="border border-slate-600">
                        {{ number_format($penjualan->sum('ppn') + $penjualan->sum('dpp'), 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- Pagination Links -->
    <div class="mt-2">
        {{ $penjualan->links() }}
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
