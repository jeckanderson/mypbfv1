<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="flex flex-row flex-wrap items-center justify-start col-span-12 gap-2">
            <!-- Periode -->
            <div class="flex items-center gap-2">
                <label for="tanggal-dari" class="inline-block mt-2 mb-2">Periode</label>
                <input id="tanggal-dari" name="mulaiId" wire:model.lazy="mulaiId" type="month"
                    placeholder="Stok dari master" style="width: 150px;"
                    class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&[readonly]]:bg-slate-100 [&[readonly]]:cursor-not-allowed [&[readonly]]:dark:bg-darkmode-800 [&[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
            </div>

            <!-- Jenis Produk -->
            <div class="flex items-center gap-2">
                {{-- <label for="jenis" class="inline-block mt-2 mb-2">Jenis Produk</label> --}}
                <select id="jenis" aria-label="Default select example" wire:model.live="jenisId"
                    class="form-control">
                    <option value="">Pilih Jenis</option>
                    @foreach ($jenis as $item)
                        <option value="{{ $item->jenis }}">{{ $item->jenis }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Golongan -->
            <div class="flex items-center gap-2">
                {{-- <label for="golongan" class="inline-block mt-2 mb-2">Golongan</label> --}}
                <select id="golongan" aria-label="Default select example" wire:model.live="golonganId"
                    class="form-control">
                    <option value="">Pilih Golongan</option>
                    @foreach ($golongan as $item)
                        <option value="{{ $item->id }}">{{ $item->sub_golongan }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-2">
                <button class="flex items-center text-white shadow-md btn btn-success" wire:ignore
                    wire:click="exportExcel" style="margin-right: 10px;">
                    <i data-feather="file-text" class="w-4 h-4 mr-1"></i>Excel
                </button>
                {{-- <a href="{{ route('cetak_pdf_kas_bank', [
                        'search' => $search,
                        'golonganId' => $golonganId,
                        'jenisId' => $jenisId,
                        'mulaiId' => $mulaiId,
                    ]) }}"
                target="_blank" class="btn btn-primary">Print PDF</a> --}}
            </div>

            <!-- Loading Indicator -->
            <div class="text-center" wire:loading wire:target="print">
                Loading PDF...
            </div>
        </div>
    </div>

    <!-- Added margin-top for spacing -->
    <div class="mt-3 box">
        <div class="overflow-auto">
            <table class="table mt-5">
                <thead class="text-center">
                    <tr>
                        <th rowspan="2" class="border border-slate-600">No</th>
                        <th rowspan="2" class="border border-slate-600">Jenis Distribusi</th>
                        <th rowspan="2" class="border border-slate-600">Tanggal Distribusi</th>
                        <th rowspan="2" class="border border-slate-600">Kode Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Jumlah Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Batch Obat Jadi</th>
                        <th rowspan="2" class="border border-slate-600">Tanggal Expired</th>
                        <th rowspan="2" class="border border-slate-600">Nomor Faktur</th>
                        <th rowspan="2" class="border border-slate-600">Tujuan</th>
                        <th rowspan="2" class="border border-slate-600">Alamat</th>
                        <th rowspan="2" class="border border-slate-600">Keterangan/Peruntukan</th>
                    </tr>

                </thead>

                <tbody>
                    @forelse ($detail as $kass)
                        <tr class="text-center intro-x">
                            <td class="border border-slate-600">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600">Dalam Negeri</td>
                            <td class="border border-slate-600">
                                {{ $kass->penjualan->tgl_input ? \Carbon\Carbon::parse($kass->penjualan->tgl_input)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="border border-slate-600">
                                {{ $kass->produk->kode_obat_bpom }}</td>
                            <td class="border border-slate-600">{{ $kass->qty }}</td>
                            <td class="border border-slate-600">{{ $kass->batch }}</td>
                            <td class="border border-slate-600">
                                {{ $kass->exp_date != '-' ? \Carbon\Carbon::parse($kass->exp_date)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="border border-slate-600">{{ $kass->penjualan->no_faktur }}</td>
                            <td class="border border-slate-600">{{ $kass->penjualan->getPelanggan->nama }}</td>
                            <td class="border border-slate-600">{{ $kass->penjualan->getPelanggan->alamat }}</td>
                            <td class="border border-slate-600">{{ $kass->Penjualan->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="font-bold text-center border text-pending border-slate-600" colspan="11">Belum
                                ada data tersedia</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>
