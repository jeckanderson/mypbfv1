<div>
    @php
        use App\Models\HistoryStok;
    @endphp
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-wrap items-center col-span-12 gap-2 mt-2 intro-y sm:flex-nowrap">
            <a href="/mutasi-stok"><button class="mr-2 btn btn-pending" wire:ignore><i data-feather="corner-up-left"
                        class="w-4 h-4 mr-1"></i>
                    Kembali</button></a>
            <div data-tw-merge class="items-center block sm:flex">
                <select data-tw-merge aria-label="Default select example" class="form-control"
                    wire:model.live='selectedGudang'>
                    <option>-- Pilih Gudang --</option>
                    @forelse ($gudangs as $gudang)
                        <option value="{{ $gudang->id }}">{{ $gudang->gudang }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <select data-tw-merge aria-label="Default select example" class="form-control"
                    wire:model.live='selectedRak'>
                    <option>-- Pilih Rak --</option>
                    @forelse ($raks as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->rak }}</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div data-tw-merge class="items-center block sm:flex">
                <select data-tw-merge aria-label="Default select example" class="form-control"
                    wire:model.live='selectedSubRak'>
                    <option>-- Pilih Sub Rak --</option>
                    @forelse ($subRak as $rak)
                        <option value="{{ $rak->id }}">{{ $rak->sub_rak }}</option>
                    @empty
                    @endforelse
                </select>
                <button onclick="location.reload()" class="btn btn-md btn-secondary ml-2" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
        </div>
    </div>
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="mt-5 intro-y box">
            <div
                class="flex flex-col items-center p-2 border-b sm:flex-row bg-primary border-slate-200/60 dark:border-darkmode-400">
                <h2 class="mr-auto text-base font-medium text-white">
                    Data Histori Stok
                </h2>
                <div class="w-full mt-3 form-check form-switch sm:w-auto sm:ml-auto sm:mt-0">
                    <div class="relative w-56 text-slate-500 ">
                        <input type="text" class="w-56 pr-10 form-control box" placeholder="Search Nama Produk ...">
                        <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table mt-2" id="historyStokTable">
                    <thead style="background-color: #e0e0e0;">
                        <tr>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(0)">Nama Produk</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(1)">No. Batch</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(2)">Exp. Date</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(3)">Stok</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(4)">Satuan</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(5)">Tipe</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(6)">Gudang</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(7)">Rak</th>
                            <th class="whitespace-nowrap cursor-pointer" onclick="sortTable(8)">Sub Rak</th>
                            <th class="text-center whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($historyStok as $history)
                            @php
                                $tercatat =
                                    HistoryStok::where('id_produk', $history->id_produk)
                                        ->where('id_gudang', $history->id_gudang)
                                        ->where('id_rak', $history->id_rak)
                                        ->where('id_sub_rak', $history->id_sub_rak)
                                        ->where('no_batch', $history->no_batch)
                                        ->sum('stok_masuk') -
                                    HistoryStok::where('id_produk', $history->id_produk)
                                        ->where('id_gudang', $history->id_gudang)
                                        ->where('id_rak', $history->id_rak)
                                        ->where('id_sub_rak', $history->id_sub_rak)
                                        ->where('no_batch', $history->no_batch)
                                        ->sum('stok_keluar');
                            @endphp
                            @if ($tercatat != 0)
                                <tr class="intro-x">
                                    <td class="w-60">{{ $history->produk->nama_obat_barang }}</td>
                                    <td class="">{{ $history->no_batch }}</td>
                                    <td class="">{{ date('d-m-Y', strtotime($history->exp_date)) }}</td>
                                    <td class="">
                                        {{ $tercatat }}
                                    </td>
                                    <td class="">{{ $history->produk->satuanTerkecil->satuan }}</td>
                                    <td class="">{{ $history->produk->tipe }}</td>
                                    <td class="">{{ $history->gudang->gudang }}</td>
                                    <td class="">{{ $history->rak->rak }}</td>
                                    <td class="">{{ $history->subRak->sub_rak }}</td>
                                    <td class="w-56 table-report__action">
                                        <div class="flex items-center justify-center">
                                            <a class="flex items-center btn btn-sm btn-outline-primary"
                                                href="javascript:;" data-tw-toggle="modal"
                                                data-tw-target="#cetak-pembelian-stok{{ $history->id }}"> Mutasi</a>
                                            <div id="cetak-pembelian-stok{{ $history->id }}" class="modal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <livewire:persediaan.mutasi-stok.tambah.modal-tambah-mutasi-stok
                                                        :tercatat="$tercatat" :history="$history" />
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr class="intro-x">
                                <td class="font-bold text-pending text-center" colspan="11">Belum ada data tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Sort the table by "Nama Produk" column on page load
    document.addEventListener("DOMContentLoaded", function() {
        sortTable(0); // 0 is the index for "Nama Produk"
    });

    function sortTable(columnIndex) {
        const table = document.getElementById("historyStokTable");
        const rows = Array.from(table.rows).slice(1); // Exclude header row

        rows.sort((a, b) => {
            let aText = a.cells[columnIndex].textContent.trim();
            let bText = b.cells[columnIndex].textContent.trim();
            return aText.localeCompare(bText);
        });

        // Reorder rows in the table
        rows.forEach(row => table.tBodies[0].appendChild(row));
    }
</script>
