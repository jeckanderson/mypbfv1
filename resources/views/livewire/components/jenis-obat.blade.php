<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Jenis Produk </label>
    <div class="flex w-full gap-1">
        <select id="input-wizard-6" class="form-select" required name="jenis_obat_barang">
            @if ($jenis_obat->isNotEmpty())
                @foreach ($jenis_obat as $jenis)
                    <option {{ $barang ? ($barang->jenis_obat_barang == $jenis->jenis ? 'selected' : '') : '' }}>
                        {{ $jenis->jenis }}</option>
                @endforeach
            @else
                <option value="">Belum ada data</option>
            @endif
        </select>
        <div class="btn btn-primary btn-sm" wire:click='openDisplay'>+</div>
    </div>
    <p class="text-primary" wire:loading>Memproses...</p>
    @if ($open)
        <div class="flex gap-1 mt-2">
            <input type="text" class="form-control" wire:model='jenis' name="" id=""
                placeholder="Masukan jenis">
            <div class="btn btn-primary btn-sm" wire:click='simpanJenis'>Simpan</div>
        </div>
    @endif
</div>
