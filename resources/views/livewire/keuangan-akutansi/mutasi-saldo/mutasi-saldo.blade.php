<div>
    {{-- modal start --}}
    @can('tambah_mutasi_saldo')
        <div id="tambah-mutasi" class="modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <livewire:keuangan-akutansi.mutasi-saldo.modal-mutasi-saldo />
            </div>
        </div>
    @endcan
    {{-- modal end --}}

    @include('components.alert')

    <div class="grid grid-cols-12 gap-2 mt-8">
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <div class="flex justify-end gap-2 mb-2">
                @can('tambah_mutasi_saldo')
                    <button class="btn btn-primary" data-tw-toggle="modal" data-tw-target="#tambah-mutasi" wire:ignore><i
                            data-feather="edit-3" class="w-4 h-4 mr-3"></i> Tambah</button>
                @endcan
                <div class="relative w-56 mr-auto text-slate-500">
                    <input type="text" class="w-56 pr-10 form-control box" placeholder="Search..."
                        wire:model.live.debounce.205ms='search'>
                    <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
                </div>
            </div>
            <table class="table -mt-2 table-report">
                <thead style="background-color: #d3d3d3;">
                    <tr style="font-weight: bold; text-align: left;">
                        <th style="white-space: nowrap; width: 50px; text-align: left;">No</th>
                        <th style="white-space: nowrap; text-align: left;">Tanggal</th>
                        <th style="white-space: nowrap; text-align: left;">No. Reff</th>
                        <th style="white-space: nowrap; text-align: left;">Akun Pengirim</th>
                        <th style="white-space: nowrap; text-align: left;">Jumlah Saldo Mutasi</th>
                        <th style="white-space: nowrap; text-align: left;">Akun Penerima</th>
                        <th style="white-space: nowrap; text-align: left;">Keterangan</th>
                        <th style="white-space: nowrap; text-align: left;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mutasiSaldo as $mutasi)
                        <tr class="intro-x">
                            <td class="">{{ $loop->iteration }}</td>
                            <td class="">{{ $mutasi->tgl_input->format('d-m-Y') }}</td>
                            <td class="">{{ $mutasi->no_reff }}</td>
                            <td class="">{{ $mutasi->akunPengirim->nama_akun }}</td>
                            <td class="">{{ number_format($mutasi->jumlah_saldo, 0, ',', '.') }}</td>
                            <td class="">{{ $mutasi->akunPenerima->nama_akun }}</td>
                            <td class="">{{ $mutasi->keterangan }}</td>
                            <td class="" wire:ignore>
                                @can('aksi_mutasi_saldo')
                                    <a href="/cetak-mutasi-saldo/{{ $mutasi->id }}">
                                        <button class="btn btn-sm btn-outline-primary">Print</button>
                                    </a>
                                    <!-- <button class="btn btn-sm btn-outline-primary">Edit</button> -->
                                    <button class="btn btn-sm btn-outline-danger"
                                        wire:click="hapusMutasiSaldo({{ $mutasi->id }})"
                                        wire:confirm="Apakah anda yakin akan menghapus data?">
                                        Delete
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="8">Belum ada data mutasi saldo
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
</div>
