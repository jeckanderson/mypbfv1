<div class="grid grid-cols-12 gap-2 mt-8">
    @php
        use App\Models\PiutangPengguna;
    @endphp
    <!-- BEGIN: Data List -->
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-3 sm:flex">
            @can('tambah_tagihan_pelanggan')
                <div class="">
                    <a href="/tambah-tagihan-pelanggan"><button class="btn btn-primary" wire:ignore><i data-feather="edit-3"
                                class="w-4 h-4 mr-3"></i> Tambah</button>
                    </a>
                </div>
            @endcan
            <div class="relative w-56 mr-auto text-slate-500" wire:ignore>
                <input type="text" class="w-56 pr-10 form-control box" placeholder="Cari nomor referensi..."
                    wire:model.live='search'>
                <i class="absolute inset-y-0 right-0 w-4 h-4 my-auto mr-3" data-feather="search"></i>
            </div>
        </div>
        <table class="table table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">Tanggal</th>
                    <th class="whitespace-nowrap">No. Reff</th>
                    <th class="whitespace-nowrap">Kolektor</th>
                    <th class="whitespace-nowrap">Area Rayon</th>
                    <th class="whitespace-nowrap">Total Piutang</th>
                    <th class="whitespace-nowrap">Keterangan</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @forelse ($dataTagihan as $tagihan)
                    <tr class="intro-x">
                        <td class="whitespace-nowrap">{{ date('d-m-Y', strtotime($tagihan->tgl_input)) }}</td>
                        <td class="whitespace-nowrap">{{ $tagihan->no_reff }}</td>
                        <td class="whitespace-nowrap">{{ $tagihan->getKolektor->nama_pegawai }}</td>
                        <td class="whitespace-nowrap">{{ $tagihan->areaRayon->area_rayon }}</td>
                        <td class="whitespace-nowrap">
                            {{ number_format(PiutangPengguna::whereIn('id', json_decode($tagihan->id_piutang))->sum('sisa_hutang'), 0, ',', '.') }}
                            @php
                                $sisa_hutang = PiutangPengguna::whereIn('id', json_decode($tagihan->id_piutang))->sum(
                                    'sisa_hutang',
                                );
                                $total += $sisa_hutang;
                                number_format($sisa_hutang);
                            @endphp
                        </td>
                        <td class="whitespace-nowrap">{{ $tagihan->keterangan }}</td>
                        <td class="flex gap-2 border border-slate-600">
                            @can('aksi_tagihan_pelanggan')
                                <a href="/cetak-tagihan-pelanggan/{{ $tagihan->id }}"><button
                                        class="btn btn-sm btn-outline-primary">Print</button></a>
                                <a href="/edit-tagihan-pelanggan/{{ $tagihan->id }}"> <button
                                        class="btn btn-sm btn-outline-primary">Edit</button></a>
                                <button class="btn btn-sm btn-outline-danger" wire:click='hapusTagihan({{ $tagihan->id }})'
                                    wire:confirm='Apakah anda yakin akan menghapus data?'>Delete</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="intro-x">
                        <td class="font-bold text-center text-pending whitespace-nowrap" colspan="7">Belum ada data
                            tersedia</td>
                    </tr>
                @endforelse
                <tr>
                    <td class="font-bold text-center border border-slate-600" colspan="4">Total</td>
                    <td class="font-bold text-left border border-slate-600" colspan="3">
                        {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- END: Data List -->
</div>
