<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\Pembelian;
        use App\Models\TerimaBarang;
    @endphp
    <div class="flex flex-wrap items-center col-span-12 gap-3 mt-2 intro-y sm:flex-nowrap">
        <div data-tw-merge class="items-center block gap-2 sm:flex">
            <button class="btn btn-primary" wire:ignore data-tw-target="#modal-setting-sp" data-tw-toggle="modal"><i
                    data-feather="settings" class="w-4 h-4 mr-3"></i> Setting No. SP </button>
            <a href="/cek-rencana-order"><button class="btn btn-pending" wire:ignore><i data-feather="edit-3"
                        class="w-4 h-4 mr-3"></i> Rencana Order </button>
            </a>
        </div>
        <div class="flex gap-2 overflow-auto whitespace-nowrap">
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Cari nomor sp"
                    wire:model.live='nomorSp'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>

            <div class="flex gap-2 justfy-center align-left">
                {{-- <p class="mt-2 font-bold">Tipe SP</p> --}}
                <select data-tw-merge aria-label="Default select example" class="w-40 form-control"
                    wire:model.live="tipeSp">
                    <option>- Pilih SP -</option>
                    <option value="REG">SP. Reguler</option>
                    <option value="OOT">SP. OOT</option>
                    <option value="Prek">SP. Prekursor</option>
                    <option value="Psiko">SP. Psikotropika</option>
                    <option value="Narko">SP. Narkotika</option>
                </select>
            </div>
            <div class="flex gap-2 justfy-center align-center">
                {{-- <p class="mt-2 font-bold">Tanggal</p> --}}
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    class="form-control" wire:model.live='tglAwal' />
                <p class="mt-3 w-full">s.d</p>
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    class="form-control" wire:model.live='tglAkhir' />
                <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                    <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
                </button>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        {{-- <div class="flex justify-end gap-3 mb-3">
            <button class="btn btn-outline-primary" data-tw-target="#modal-setting-sp" data-tw-toggle="modal">Setting
                No. SP</button>
            <a href="/cek-rencana-order"><button class="btn btn-outline-pending">Rencana Order</button></a>
        </div> --}}

        {{-- modal start --}}
        <div id="modal-setting-sp" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    @livewire('pembuatan-sp.set-no-sp')
                </div>
            </div>
        </div>
        {{-- modal end --}}

        <table class="table -mt-2 table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">No Reff</th>
                    <th class="whitespace-nowrap">Tgl SP</th>
                    <th class="whitespace-nowrap">Supplier</th>
                    <th class="whitespace-nowrap">No SP</th>
                    <th class="whitespace-nowrap">Tipe SP</th>
                    <th class="whitespace-nowrap">Status SP</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($surats as $surat)
                    <tr class="intro-x">
                        <td class="">{{ $loop->iteration }}</td>
                        <td class="">{{ $surat->no_reff }}</td>
                        <td class="">{{ $surat->tgl_sp->format('d-m-Y') }}</td>
                        <td class="">{{ $surat->suplier->nama_suplier }}</td>
                        <td class="">{{ $surat->no_sp }}</td>
                        <td class="">
                            @if ($surat->tipe_sp == 'REG')
                                SP Reguler
                            @elseif($surat->tipe_sp == 'OOT')
                                SP. OOT
                            @elseif($surat->tipe_sp == 'Prek')
                                SP. Prekusor
                            @elseif($surat->tipe_sp == 'Psiko')
                                SP. Psikotropika
                            @elseif($surat->tipe_sp == 'Narko')
                                SP. Narkotika
                            @endif
                        </td>
                        <td class="">
                            @if (Pembelian::where('id_sp', $surat->id)->exists() && !TerimaBarang::where('id_sp', $surat->id)->exists())
                                <p class="text-pending">On Proses Terima Barang</p>
                            @elseif(TerimaBarang::where('id_sp', $surat->id)->exists())
                                <p class="text-success">Selesai</p>
                            @else
                                <p class="text-danger">Barang Dipesan</p>
                            @endif
                        </td>
                        <td class="flex gap-2 w-60">
                            <a href="{{ route('export_pemesanan_suplier_pdf', ['id_sp' => $surat->id]) }}"
                                class="btn btn-outline-primary btn-sm"> Print </a>
                            @if (!Pembelian::where('id_sp', $surat->id)->exists())
                                {{-- <button class="btn btn-outline-primary btn-sm">Edit</button> --}}
                                <button class="btn btn-outline-danger btn-sm" wire:loading.remove
                                    wire:click="deleteSP({{ $surat->id }})"
                                    wire:confirm="Anda yakin akan menghapus surat pesanan?">
                                    Delete
                                </button>
                                <button class="btn btn-danger btn-sm" wire:loading
                                    wire:target="deleteProduk({{ $surat->id }})">
                                    Menghapus...
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-pending text-center" colspan="8">Belum ada data tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
