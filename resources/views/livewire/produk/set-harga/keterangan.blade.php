<div class="col-span-12 mt-5 intro-y lg:col-span-6">
    <!-- BEGIN: Input -->
    <div class="intro-y box">
        <div class="flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
            <h2 class="mr-auto font-medium text-primary">
                Setting Harga Jual
            </h2>
        </div>
        <div class="p-5">
            <div class="flex justify-center w-full gap-3 mt-6 mb-6">
                <div class="col-span-20 intro-y sm:col-span-6">
                    <label for="input-wizard-6" class="form-label">Stok Awal</label>
                    <select class="form-select" wire:model.live="selectedStok" {{ $hideStok }}>
                        <option value="">- Pilih -</option>
                        @forelse ($stoks as $stok)
                            @if (
                                $stok->histori->sisaStokBatch($stok->id_obat_barang, $stok->no_batch, $stok->gudang, $stok->rak, $stok->sub_rak) !=
                                    0)
                                <option value="{{ $stok->id }}">
                                    {{ $stok->no_reff . ' | ' . $stok->no_batch }}
                                </option>
                            @endif
                        @empty
                            <option value="">Belum ada stok yang ditambahkan</option>
                        @endforelse
                    </select>
                </div>

                <div class="col-span-12 intro-y sm:col-span-6">
                    <label for="input-wizard-6" class="form-label">Stok Masuk</label>
                    <select class="form-select" wire:model.live="selectedOpname" {{ $hideOpname }}>
                        <option value="">- Pilih -</option>
                        @forelse ($opnames as $opname)
                            @if (
                                $opname->histori->sisaStokBatch(
                                    $opname->id_produk,
                                    $opname->no_batch,
                                    $opname->gudang,
                                    $opname->rak,
                                    $opname->sub_rak) != 0)
                                <option value="{{ $opname->id }}">
                                    {{ $opname->no_reff . ' | ' . $opname->no_batch }}
                            @endif
                        @empty
                            <option value="">Belum ada stok yang ditambahkan</option>
                        @endforelse
                    </select>
                </div>

                <div class="col-span-12 intro-y sm:col-span-6">
                    <label for="input-wizard-6" class="form-label">Pembelian</label>
                    <select class="form-select" wire:model.live='selectedPembelian' {{ $dis2 }}
                        {{ $hidePembelian }}>
                        <option value="">- Pilih -</option>
                        @forelse ($pembelians as $pembelian)
                            @if (
                                $pembelian->histori->sisaStokBatch(
                                    $pembelian->id_produk,
                                    $pembelian->no_batch,
                                    $pembelian->gudang,
                                    $pembelian->rak,
                                    $pembelian->sub_rak) != 0)
                                <option value="{{ $pembelian->id }}">
                                    {{ $pembelian->pembelian->no_reff . ' | ' . $pembelian->no_batch }}
                                </option>
                            @endif
                        @empty
                            <option value="">Belum ada stok yang ditambahkan</option>
                        @endforelse
                    </select>
                </div>
            </div>
            {{-- <div class="grid grid-cols-12 gap-4 text-center"> --}}
            <div class="flex items-center justify-center w-full text-center">
                @php
                    $hpp = $hppPembelian ?? ($stokMasuk->hpp ?? ($stokOpname->hpp ?? ''));
                    $hppStok = $stokMasuk->hpp ?? '';
                    $hpp = doubleval($hpp);
                @endphp
                <div class="w-1/2 col-span-12 font-bold intro-y sm:col-span-6">
                    <label for="input-wizard-3" class="form-label">HPP Final /
                        {{ $produk->satuanTerkecil->satuan }}</label>
                    <input id="input-wizard-3" type="text" class="form-control" placeholder="" readonly
                        value="{{ $hpp ? number_format($hpp, 5, ',', '.') : '' }}">
                </div>
            </div>
            <div class="flex justify-center w-full gap-3 mt-6">
                <div class="col-span-12 intro-y sm:col-span-6">
                    <label for="satuan-dasar" class="form-label">Satuan Dasar</label>
                    <input id="satuan-dasar" type="text" class="form-control" readonly placeholder=""
                        value="{{ $produk->satuanDasar->satuan }}">
                </div>
                <div class="col-span-12 intro-y sm:col-span-6">
                    <label for="isi" class="form-label">Isi</label>
                    <input id="isi" type="text" class="form-control" readonly placeholder=""
                        value="{{ $produk->isi }}">
                </div>
                <div class="col-span-12 intro-y sm:col-span-6">
                    <label for="satuan-jual-terkecil" class="form-label">Satuan Jual Terkecil</label>
                    <input id="satuan-jual-terkecil" type="text" class="form-control" readonly placeholder=""
                        value="{{ $produk->satuanTerkecil->satuan }}">
                </div>
            </div>
        </div>
    </div>
</div>
