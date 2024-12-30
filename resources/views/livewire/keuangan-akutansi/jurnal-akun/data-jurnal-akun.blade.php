<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\DetailJurnalAkun;
    @endphp
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">

        <div class="flex justify-end gap-2 mb-2">
            @can('tambah_jurnal_akun')
                <a href="/tambah-jurnal-akun"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i>
                        Tambah</button>
                </a>
            @endcan
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search no. reff"
                    wire:model.live.debounce.250ms='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <table class="table -mt-2 table-report">
            <thead style="background-color: #d3d3d3;">
                <tr class="font-bold text-left">
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">Nilai Jurnal</th>
                    <th class="whitespace-nowrap">User</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jurnalAkun as $key => $jurnal)
                    @php
                        $name = $jurnal->detail_jurnal->pengguna->name;
                    @endphp
                    <tr class="intro-x">
                        <td class="">{{ $loop->iteration }}</td>
                        <td class="">{{ $jurnal->no_reff }}</td>
                        <td class="">{{ $jurnal->tgl_input->format('d-m-Y') }}</td>
                        <td class="">
                            {{ number_format($jurnal->detail_jurnal_akun()->sum('debet'), 0, ',', '.') }}
                        </td>
                        <td class="">{{ $name }}</td>
                        <td class="">{{ $jurnal->keterangan ?? 'Tidak Tersedia' }}</td>
                        <td class="">
                            @can('aksi_jurnal_akun')
                                <a href="/cetak-jurnal-akun/{{ $jurnal->id }}"> <button
                                        class="btn btn-outline-primary">Print</button></a>
                                <button class="btn btn-outline-danger" wire:click='hapusJurnal({{ $jurnal->id }})'
                                    wire:confirm='Apakah anda yakin akan menghapus data?'>Delete</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending" colspan="7">Belum ada data tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
