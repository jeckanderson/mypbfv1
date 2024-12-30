<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\Penjualan;
    @endphp
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-2 sm:flex" wire:ignore>
            <button class="btn btn-pending" wire:click='kirimPenjualan' wire:loading.remove> Kirim Ke Penjualan</button>
            <button class="text-white btn btn-pending" disabled wire:loading>Mengirim...</button>
            <div class="relative w-56 mb-2 text-slate-500 sm:mb-0">
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search No. Reff ..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
            <div class="flex gap-2 mb-2 overflow-auto sm:mb-0">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                    Tanggal
                </label> --}}
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    wire:model.live='startDate'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                <p class="w-full mt-3">s.d</p>
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    wire:model.live='endDate'
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>
            <button onclick="location.reload()" class="btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>
        </div>
        <div class="overflow-auto">
            <table class="table table-report">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">No</th>
                        <th class="whitespace-nowrap">Tgl. Input SP</th>
                        <th class="whitespace-nowrap">No. Reff Input</th>
                        <th class="whitespace-nowrap">Tgl SP</th>
                        <th class="whitespace-nowrap">No. SP</th>
                        <th class="whitespace-nowrap">Pelanggan</th>
                        <th class="whitespace-nowrap">Sales</th>
                        <th class="whitespace-nowrap">Tipe SP</th>
                        <th class="whitespace-nowrap">Sumber</th>
                        <th class="whitespace-nowrap">Status Di Cek</th>
                        <th class="whitespace-nowrap">Di Penjualan</th>
                        <th class="whitespace-nowrap">
                            Pilih
                        </th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($spPenjualan as $sp)
                        <tr class="intro-x">
                            <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                            <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($sp->tgl_input)) }}</td>
                            <td class="whitespace-nowrap">{{ $sp->no_reff }}</td>
                            <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($sp->tgl_sp)) }}</td>
                            <td class="whitespace-nowrap">{{ $sp->no_sp }}</td>
                            <td class="whitespace-nowrap">{{ $sp->pelangganPenjualan->nama }}</td>
                            <td class="whitespace-nowrap">{{ $sp->salesPenjualan->nama_pegawai }}</td>
                            <td class="whitespace-nowrap">{{ $sp->tipe_sp }}</td>
                            <td class="whitespace-nowrap">{{ $sp->sumber }}</td>
                            <td class="whitespace-nowrap">
                                @if ($sp->status_cek == 0)
                                    <p class="font-bold">Belum</p>
                                @else
                                    <p class="font-bold text-success">Sudah</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap">
                                @if ($sp->kirim_penjualan == 0)
                                    <p class="font-bold">Belum</p>
                                @elseif(Penjualan::where('id_sp', $sp->id)->first())
                                    <p class="font-bold text-success">Selesai</p>
                                @else
                                    <p class="font-bold text-pending">Proses</p>
                                @endif
                            </td>
                            <td class="whitespace-nowrap">
                                @if ($sp->kirim_penjualan == 0 && $sp->status_cek == 1)
                                    <input data-tw-merge type="checkbox" wire:model='selectedSP'
                                        class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                        id="checkbox-switch-1" value="{{ $sp->id }}" />
                                @endif
                            </td>
                            <td class="flex-auto gap-2 border border-slate-600 whitespace-nowrap">
                                {{-- <button class="btn btn-outline-primary btn-sm">Detail</button> --}}
                                @can('aksi_cek_sp_penjualan')
                                    @if (!Penjualan::where('id_sp', $sp->id)->first())
                                        <a href="/edit-pesanan-penjualan/{{ $sp->id }}"><button
                                                class="btn btn-outline-primary btn-sm">
                                                Cek SP</button></a>
                                        <a href="{{ route('printSP', $sp->id) }}"
                                            class="btn btn-outline-primary btn-sm">Print</a>
                                        <button class="btn btn-outline-danger btn-sm"
                                            wire:click='deleteSP({{ $sp->id }})'
                                            wire:confirm="Yakin dihapus? data akan dikirim kembali ke pembuatan SP">Delete</button>
                                    @endif
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-center text-pending" colspan="13">Belum ada data SP tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- END: Data List -->
</div>
