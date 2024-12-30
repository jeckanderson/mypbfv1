<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Kategori</label>
    <div class="flex w-full gap-1">
        <select id="input-wizard-6" class="form-select" required name="golongan">
            @if ($golongans->isNotEmpty())
                @foreach ($golongans as $gol)
                    <option value="{{ $gol->id }}"
                        {{ $barang ? ($barang->golongan == $gol->id ? 'selected' : '') : '' }}>
                        {{ $gol->golongan }}</option>
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
            <input type="text" class="form-control" wire:model='kategori' name="" id=""
                placeholder="Masukan kategori">
            <div class="btn btn-primary btn-sm" wire:click='simpanKategori'>Simpan</div>
        </div>
    @endif
</div>
