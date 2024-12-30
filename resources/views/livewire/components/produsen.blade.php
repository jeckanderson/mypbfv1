<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Produsen</label>
    <div class="flex w-full gap-1">
        <select id="input-wizard-6" class="form-select" required name="produsen">
            @if ($produsens->isNotEmpty())
                @foreach ($produsens as $prod)
                    <option value="{{ $prod->id }}"
                        {{ $barang ? ($barang->produsen == $prod->id ? 'selected' : '') : '' }}>
                        {{ $prod->produsen }}</option>
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
            <input type="text" class="form-control" wire:model='produsen' name="" id=""
                placeholder="Masukan produsen">
            <div class="btn btn-primary btn-sm" wire:click='simpanJenis'>Simpan</div>
        </div>
    @endif
</div>
