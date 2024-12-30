<div>
    <div class="flex justify-between mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium">
            Tambah Saldo Awal
        </h2>
        <h2 class="w-64 p-3 font-medium text-center text-white rounded-lg bg-primary">
            Tanggal Saldo Awal: {{ $tgl_saldo }}
        </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-wrap items-center col-span-12 mt-2 intro-y sm:flex-nowrap">
            <a href="/saldo-awal"><button class="mr-2 btn btn-secondary"><i data-feather="corner-up-left"
                        class="w-4 h-4 mr-1"></i>
                    Kembali</button></a>
            <button class="mr-2 shadow-md btn btn-primary" data-tw-toggle="modal"
                data-tw-target="#basic-modal-preview">Tambah
                Data +</button>
            <!-- BEGIN: Modal Content -->
            <div id="basic-modal-preview" class="modal" tabindex="-1" aria-hidden="true">
                <div class="rounded-lg modal-dialog modal-xl">
                    <livewire:set-awal.saldo-awal.modal-tambah-saldo-awal />
                </div>
            </div>
            <!-- END: Modal Content -->

            <div class="relative w-56 text-slate-500 ">
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search...">
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
    </div>
    <!-- BEGIN: Data List -->
    <div class="col-span-12 mt-5 overflow-auto intro-y lg:overflow-visible">
        <div class="overflow-x-auto">
            <table class="table -mt-2 table-report">
                <thead>
                    <tr>
                        <th class="whitespace-nowrap">No.</th>
                        <th class="whitespace-nowrap">Nama Akun</th>
                        <th class="whitespace-nowrap">Saldo Sebelum</th>
                        <th class="whitespace-nowrap">Saldo Sesudah</th>
                        <th class="text-center whitespace-nowrap">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($temp_saldo as $saldo)
                        <tr class="intro-x" wire:key='saldo-{{ $saldo->id }}'>
                            <td class="w-40">{{ $loop->iteration }}</td>
                            <td class="">{{ $saldo->akun->nama_akun }}</td>
                            <td class="">{{ number_format($saldo->saldo_sebelum,'0',',','.') }}</td>
                            <td class="">{{ number_format($saldo->saldo_sesudah,'0',',','.') }}</td>
                            <td class="table-report__action w-72" wire:ignore>
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center btn text-danger"
                                        wire:click='hapusSaldo({{ $saldo->id }})'
                                        wire:confirm='Apakah anda yakin akan menghapus?'> <i data-feather="trash-2"
                                            class="w-4 h-4 mr-1"></i> Delete </div>
                                    <!-- BEGIN: Delete Confirmation Modal -->
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center" colspan="5">Belum ada saldo sementara ditambahkan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="flex justify-end gap-3 mt-5">
                <button class="px-10 btn btn-secondary" data-tw-toggle="modal"
                    data-tw-target="#cancel-confirmation-modal">Batal</button>
                <button class="px-10 btn btn-primary" wire:confirm='Apakah anda yakin akan menyimpan ini ke Saldo Awal?'
                    wire:click='simpanSaldoAwal'>Simpan</button>

                <div id="cancel-confirmation-modal" class="modal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="p-0 modal-body">
                                <div class="p-5 text-center">
                                    <i data-feather="x-circle" class="w-16 h-16 mx-auto mt-3 text-danger"></i>
                                    <div class="mt-5 text-3xl">Yakin Kembali?</div>
                                    <div class="mt-2 text-slate-500">
                                        Perubahan tidak akan disimpan
                                    </div>
                                </div>
                                <div class="px-5 pb-8 text-center">
                                    <button type="button" data-tw-dismiss="modal"
                                        class="w-24 mr-1 btn btn-outline-secondary">Kembali</button>
                                    <a href="/saldo-awal"><button type="button"
                                            class="w-24 btn btn-danger">Batalkan</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
