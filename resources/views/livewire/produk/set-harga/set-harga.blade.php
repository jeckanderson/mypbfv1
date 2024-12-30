<div>
    @php
        use App\Models\SetHarga;
    @endphp

    @if (SetHarga::where('id_set_harga', $pembelian || $stok || $opname ? $pembelian->id ?? ($stok->id ?? $opname->id) : '')->groupBy('id_kelompok')->where('sumber', $sumber)->get()->isNotEmpty())
        <form action="{{ route('update.setHarga') }}" method="POST">
        @else
            <form action="{{ route('create.setHarga') }}" method="POST">
    @endif
    @csrf

    <livewire:produk.set-harga.keterangan :id="$id" />
    @if (SetHarga::where('id_set_harga', $pembelian || $stok || $opname ? $pembelian->id ?? ($stok->id ?? $opname->id) : '')->groupBy('id_kelompok')->where('sumber', $sumber)->first())
        <div class="col-span-12 mt-5 intro-y lg:col-span-6">
            <div class="intro-y box">
                <div
                    class="flex flex-col items-center p-5 text-white border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                    <ul class="flex-col justify-center text-center text-white nav nav-link-tabs sm:flex-row lg:justify-start"
                        role="tablist">
                        @foreach (SetHarga::where('id_set_harga', $pembelian || $stok || $opname ? $pembelian->id ?? ($stok->id ?? $opname->id) : '')->where('sumber', $sumber)->groupBy('id_kelompok')->get() as $set)
                            <li id="pane{{ $set->kelompok->id }}-tab" class="nav-item" role="presentation"> <a
                                    href="javascript:;" class="py-4 nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-tw-target="#pane{{ $set->kelompok->id }}"
                                    aria-controls="pane{{ $set->kelompok->id }}"
                                    aria-selected="{{ $loop->first ? 'active' : 'false' }}" role="tab">
                                    <h3 class="text-base font-medium">Harga Jual
                                        {{ $set->kelompok->kelompok }}</h3>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="mt-5 intro-y tab-content">
                @foreach (SetHarga::where('id_set_harga', $pembelian || $stok || $opname ? $pembelian->id ?? ($stok->id ?? $opname->id) : '')->where('sumber', $sumber)->groupBy('id_kelompok')->get() as $set)
                    <div id="pane{{ $set->kelompok->id }}" class="tab-pane {{ $loop->first ? 'active' : '' }}"
                        role="tabpanel" aria-labelledby="pane{{ $set->kelompok->id }}-tab">
                        <div class="intro-y box">
                            <livewire:produk.set-harga.data-set-harga :id="$id" :set="$set"
                                :sumber="$sumber" wire:key="$set->id" :pembelian="$pembelian" :stok="$stok"
                                :hppFinalPembelian="$hpp_final" :opname="$opname" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        {{-- jika data harga belum di set --}}
        <livewire:produk.set-harga.data-set-kelompok :id="$id" />
    @endif

    {{-- button save --}}
    @if ($sumber)
        <div class="flex justify-center gap-2 mt-5">
            <button type="submit" class="px-6 btn btn-primary">Simpan</button>
            <a href="/obat-dan-barang" class="btn btn-outline-danger">Batal</a>
        </div>
    @endif
</div>
