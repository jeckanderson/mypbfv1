<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\PiutangPengguna;
    @endphp
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-3 sm:flex">
            @can('tambah_kontra_bon')
                <div class="">
                    <a href="/tambah-kontrabon"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                                class="w-4 h-4 mr-3"></i> Tambah</button>
                    </a>
                </div>
            @endcan
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search No. Reff ..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="table table-report">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">Tanggal</th>
                        <th class="whitespace-nowrap">No. Reff</th>
                        <th class="whitespace-nowrap">Pelanggan</th>
                        <th class="whitespace-nowrap">Petugas</th>
                        <th class="whitespace-nowrap">Total</th>
                        <th class="whitespace-nowrap">Keterangan</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kontrabons as $item)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($item->tgl_input)) }}</td>
                            <td class="whitespace-nowrap">{{ $item->no_reff }}</td>
                            <td class="whitespace-nowrap">{{ $item->getPelanggan->nama }}</td>
                            <td class="whitespace-nowrap">{{ $item->getSales->nama_pegawai }}</td>
                            <td class="whitespace-nowrap">
                                {{ number_format(PiutangPengguna::whereIn('id', json_decode($item->id_piutang))->sum('sisa_hutang'), 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap">{{ $item->keterangan }}</td>
                            <td class="flex gap-2 border">
                                @can('aksi_kontra_bon')
                                    <a href="/cetak-kontrabon/{{ $item->id }}"> <button
                                            class="btn btn-sm btn-outline-primary">Print</button></a>
                                    {{-- <a href="/edit-kontrabon/{{ $item->id }}"><button
                                        class="btn btn-sm btn-outline-primary">Edit</button></a> --}}
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click='hapusKontrabon({{ $item->id }})'
                                        wire:confirm='Apakah anda yakin akan menghapus data kontrabon?'>Delete</button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending whitespace-nowrap" colspan="7">Belum ada
                                data tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
