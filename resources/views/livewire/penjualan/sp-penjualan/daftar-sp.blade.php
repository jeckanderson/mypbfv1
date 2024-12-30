@include('components.alert')
<div class="grid grid-cols-12 gap-2 mt-8">
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">

        <div class="gap-2 sm:flex">
            @can('tambah_sp_penjualan')
                <a href="/tambah-sp-penjualan"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                            class="w-4 h-4 mr-3"></i> Tambah</button>
                </a>
            @endcan
            <button class="btn btn-pending" wire:click='kirimCekSP' wire:loading.remove>Kirim Cek SP -> </button>
            <button class="btn btn-pending" disabled wire:loading>Mengirim Ke Cek SP...</button>
            <div class="relative w-56 mb-2 text-slate-500 sm:mb-0" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Search No. SP ..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
            <div class="flex gap-2 mb-2 overflow-auto sm:mb-0">
                {{-- <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-20">
                    Tanggal
                </label> --}}
                <input data-tw-merge id="horizontal-form-1" type="date" placeholder="Stok dari master"
                    wire:model.debounce.live='startDate'
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
        <table class="table table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">Tgl. SP</th>
                    <th class="whitespace-nowrap">No. SP</th>
                    <th class="whitespace-nowrap">Pelanggan</th>
                    <th class="whitespace-nowrap">Sales</th>
                    <th class="whitespace-nowrap">Tipe SP</th>
                    <th class="whitespace-nowrap">Sumber</th>
                    <th class="whitespace-nowrap">Pilih</th>
                    {{-- <th class="whitespace-nowrap">
                        <input data-tw-merge type="checkbox"
                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                            id="master" value="" />
                    </th> --}}
                    <th class="whitespace-nowrap">Status</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarSP as $sp)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($sp->tgl_input)) }}</td>
                        <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($sp->tgl_sp)) }}</td>
                        <td class="whitespace-nowrap">{{ $sp->no_sp }}</td>
                        <td class="whitespace-nowrap">{{ $sp->pelangganPenjualan->nama }}</td>
                        <td class="whitespace-nowrap">{{ $sp->salesPenjualan->nama_pegawai }}</td>
                        <td class="whitespace-nowrap">{{ $sp->tipe_sp }}</td>
                        <td class="whitespace-nowrap">{{ $sp->sumber }}</td>
                        <td class="whitespace-nowrap">
                            @if ($sp->kirim_cek_sp == 0)
                                <input data-tw-merge type="checkbox" wire:model='selectedSP'
                                    class="select transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer rounded focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;[type=&#039;radio&#039;]]:checked:bg-primary [&amp;[type=&#039;radio&#039;]]:checked:border-primary [&amp;[type=&#039;radio&#039;]]:checked:border-opacity-10 [&amp;[type=&#039;checkbox&#039;]]:checked:bg-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-primary [&amp;[type=&#039;checkbox&#039;]]:checked:border-opacity-10 [&amp;:disabled:not(:checked)]:bg-slate-100 [&amp;:disabled:not(:checked)]:cursor-not-allowed [&amp;:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&amp;:disabled:checked]:opacity-70 [&amp;:disabled:checked]:cursor-not-allowed [&amp;:disabled:checked]:dark:bg-darkmode-800/50"
                                    id="checkbox-switch-1{{ $sp->id }}" value="{{ $sp->id }}" />
                            @endif
                        </td>
                        <td class="whitespace-nowrap">
                            {!! $sp->kirim_cek_sp == 0 ? 'Tersedia' : ' <p class="font-bold text-success">Terkirim</p>' !!}</td>
                        <td class="flex gap-2 border border-slate-600">
                            @can('aksi_sp_penjualan')
                                {{-- <button class="btn btn-sm btn-outline-primary">Detail</button> --}}
                                <a href="/cetak-sp-penjualan/{{ $sp->id }}"> <button
                                        class="btn btn-sm btn-outline-primary"> Print </button></a>
                                @if ($sp->kirim_cek_sp == 0)
                                    {{-- <button class="btn btn-sm btn-outline-primary">Edit</button> --}}
                                    <button class="btn btn-sm btn-outline-danger" wire:click='hapusSP({{ $sp->id }})'
                                        wire:confirm="Apakah anda yakin akan menghapus ini?">Delete</button>
                                @endif
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending whitespace-nowrap" colspan="11">Belum ada data
                            tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>

<script>
    var j = jQuery.noConflict();
    j(document).ready(function() {
        j('#master').on('click', function(e) {
            if (j(this).is(':checked', true)) {
                j(".select").prop('checked', true);
            } else {
                j(".select").prop('checked', false);
            }
        });
    })
</script>
