<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-2 sm:flex">
            @can('tambah_penjualan')
                <a href="/tambah-penjualan"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i>
                        Tambah</button>
                </a>
            @endcan
            <!-- <div class="relative w-56 mb-2 mr-auto text-slate-50 sm:mb-0">
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Cari No Faktur">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-2" data-feather="search"></i>
            </div> -->
            @include('components.search', [
                'id_table' => 'myTable',
            ])
            <div data-tw-merge class="items-center block ml-1 sm:flex">
                <select data-tw-merge aria-label="Default select example" class="form-control" name="selectedOption"
                    id="filterSelect" onchange="selectOption()">
                    <option value="">- Semua Status -</option>
                    <option value="Kredit">Kredit</option>
                    <option value="Tunai">Tunai</option>
                </select>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table mt-0 table-report" id="myTable">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">No. SP</th>
                        <th class="whitespace-nowrap">Tgl. Faktur</th>
                        <th class="whitespace-nowrap">No. Faktur</th>
                        <th class="text-left whitespace-nowrap" style="text-align: left;">Pelanggan</th>
                        <th class="text-left whitespace-nowrap" style="text-align: left;">Sales</th>
                        <th class="whitespace-nowrap">Status</th>
                        <th class="whitespace-nowrap">Tgl JT</th>
                        <th class="whitespace-nowrap">No Seri Pajak</th>
                        <th class="whitespace-nowrap">DPP</th>
                        <th class="whitespace-nowrap">PPN</th>
                        <th class="whitespace-nowrap">Total</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualans as $penjualan)
                        <tr class="intro-x">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $penjualan->no_sp }}</td>
                            <td class="text-center">{{ $penjualan->tgl_faktur->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $penjualan->no_faktur }}</td>
                            <td class="text-left">{{ $penjualan->getPelanggan->nama }}</td>
                            <td class="text-left">{{ $penjualan->getSales->nama_pegawai }}</td>
                            <td class="text-center">{{ $penjualan->kredit == 0 ? 'Tunai' : 'Kredit' }}</td>
                            <td class="text-center">{{ $penjualan->tempo_kredit->format('d-m-Y') }}</td>
                            <td class="text-center">{{ $penjualan->no_seri_pajak }}</td>
                            <td class="text-right">{{ number_format($penjualan->dpp, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($penjualan->ppn, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($penjualan->total_tagihan, 0, ',', '.') }}</td>
                            <td class="flex gap-2">
                                @can('aksi_penjualan')
                                    <a href="{{ route('penjualan.print', $penjualan->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary">Print</a>
                                    <!-- <button class="btn btn-sm btn-outline-primary">Edit</button> -->

                                    <button class="btn btn-sm btn-outline-primary" data-tw-toggle="modal"
                                        data-tw-target="#data-pajak{{ $penjualan->id }}" data-id="{{ $penjualan->id }}">
                                        No. Pajak
                                    </button>
                                    {{-- modal cari no seri pajak --}}
                                    <div id="data-pajak{{ $penjualan->id }}" class="modal" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <livewire:penjualan.penjualan.modal-tambah-seri-pajak :id="$penjualan->id" />
                                        </div>
                                    </div>

                                    @if ($penjualan->retur->isEmpty())
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click='hapusPenjualan({{ $penjualan->id }})'
                                            wire:confirm='Apakah anda yakin akan menghapus data penjualan?'>Delete</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="13">Belum ada data tersedia</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="font-bold text-right" colspan="9">Total</td>
                        <td class="font-bold text-right" id="totalDpp">
                            {{ number_format($penjualans->sum('dpp'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold text-right" id="totalPpn">
                            {{ number_format($penjualans->sum('ppn'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold text-right" id="totalTagihan">
                            {{ number_format($penjualans->sum('total_tagihan'), 0, ',', '.') }}
                        </td>
                        <td class="font-bold text-center"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>

<script>
    function formatRupiah(angka) {
        let numberString = angka.toFixed(2).toString();
        let splitNumber = numberString.split('.');
        let rupiah = splitNumber[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
        return rupiah;
    }

    function selectOption() {
        let filterSelect = document.getElementById("filterSelect").value;
        console.log(filterSelect);
        let myTable = document.getElementById("myTable");
        let tr = myTable.getElementsByTagName("tr");
        var i, txtValue, td, dpp, ppn, tagihan;
        let totalDpp = document.getElementById("totalDpp");
        let totalPpn = document.getElementById("totalPpn");
        let totalTagihan = document.getElementById("totalTagihan");
        let tDpp = 0;
        let tPpn = 0;
        let tTagihan = 0;

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[6];
            dpp = tr[i].getElementsByTagName("td")[9];
            ppn = tr[i].getElementsByTagName("td")[10];
            tagihan = tr[i].getElementsByTagName("td")[11];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase() === filterSelect.toUpperCase() || filterSelect === "") {
                    tr[i].style.display = "";

                    // Bersihkan nilai hutang dari karakter non-numerik dan ganti koma dengan titik
                    let dppText = dpp.textContent.replace(/[^\d,]/g, '').replace(',', '.');
                    let dppCleaned = parseFloat(dppText);
                    let ppnText = ppn.textContent.replace(/[^\d,]/g, '').replace(',', '.');
                    let ppnCleaned = parseFloat(ppnText);
                    let tagihanText = tagihan.textContent.replace(/[^\d,]/g, '').replace(',', '.');
                    let tagihanCleaned = parseFloat(tagihanText);

                    tDpp += dppCleaned;
                    tPpn += ppnCleaned;
                    tTagihan += tagihanCleaned;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // Setel total hutang setelah menghitung nilai dalam format yang diinginkan
        totalDpp.textContent = formatRupiah(tDpp);
        totalPpn.textContent = formatRupiah(tPpn);
        totalTagihan.textContent = formatRupiah(tTagihan);
    }
</script>
