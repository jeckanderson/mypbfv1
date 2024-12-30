<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-wrap items-center justify-between col-span-12 gap-2 md:col-span-12">
            {{-- <div class="flex items-center">
                <label for="search" class="inline-block mt-2 mb-2 sm:w-24">Cari</label>
                <input type="text" id="search" name="search" wire:model.live.debounce.300ms="search"
                    class="block w-full rounded-md shadow-sm form-input" style="width: 150px;">
            </div> --}}
            <div class="flex items-center">
                {{-- <label for="tanggal-dari" class="inline-block mt-2 mb-2 sm:w-24">Tanggal</label> --}}
                <div>
                    <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="month" style="width: 150px;"
                        class="w-full text-sm transition duration-200 ease-in-out rounded-md shadow-sm disabled:bg-slate-100 disabled:cursor-not-allowed border-slate-200 focus:ring-4 focus:ring-primary focus:border-primary" />
                </div>
            </div>

            <div class="flex items-center">
                {{-- <label for="jenis" class="inline-block mt-2 mb-2 sm:w-24">Jenis Produk</label> --}}
                <select id="jenis" wire:model.live="jenisId" class="form-control" style="width: 170px;">
                    <option value="">Pilih Jenis Produk</option>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center">
                {{-- <label for="golongan" class="inline-block mt-2 mb-2 sm:w-24">Golongan</label> --}}
                <select id="golongan" wire:model.live="golonganId" class="form-control" style="width: 150px;">
                    <option value="">Pilih Golongan</option>
                    @foreach ($golongan as $item)
                        <option value="{{ $item->id }}">{{ $item->sub_golongan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end">
                <button class="flex items-center text-white shadow-md btn btn-success" wire:ignore
                    wire:click="exportExcel" style="margin-right: 10px;">
                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                </button>
            </div>

            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>
    <div class="mt-5 box">
        <div class="overflow-auto">
            <table class="table">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="border border-slate-600">No</th>
                        <th rowspan="2" class="border border-slate-600">Jenis Transaksi</th>
                        <th rowspan="2" class="border border-slate-600">Tanggal Masukan</th>
                        <th rowspan="2" class="border border-slate-600">Kode Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Jumlah Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Batch Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Tanggal Expired</th>
                        <th rowspan="2" class="border border-slate-600">Nomor Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Sumber</th>
                        <th rowspan="2" class="border border-slate-600">Keterangan/Peruntukan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kas as $kass)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">Dalam Negeri</td>
                            <td class="border border-slate-600">
                                {{ \Carbon\Carbon::parse($kass->pembelian->tgl_input)->format('d-m-Y') }}
                            </td>
                            <td class="border border-slate-600">{{ $kass->produk->kode_obat_bpom }}</td>
                            <td class="border border-slate-600">{{ $kass->qty_faktur }}</td>
                            <td class="border border-slate-600">
                                @if ($kass->ProdukDiterima)
                                    {{ $kass->ProdukDiterima->no_batch }}
                                @else
                                    <small class="text-danger">Belum di gudang</small>
                                @endif
                            </td>
                            <td class="border border-slate-600">
                                {{ \Carbon\Carbon::parse($kass->pembelian->tgl_faktur)->format('d-m-Y') }}
                            </td>
                            <td class="border border-slate-600">{{ $kass->pembelian->no_faktur }}</td>
                            <td class="border border-slate-600">{{ $kass->pembelian->getSuplier->nama_suplier }}</td>
                            <td class="border border-slate-600">{{ $kass->Pembelian->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="10">Belum
                                ada data
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
