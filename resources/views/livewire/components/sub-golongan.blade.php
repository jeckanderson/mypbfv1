<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Golongan</label>
    <div class="flex w-full gap-1">
        <select id="input-wizard-6" class="form-select" required name="sub_golongan">
            @if ($sub_golongans->isNotEmpty())
                @foreach ($sub_golongans as $gol)
                    <option value="{{ $gol->id }}"
                        {{ $barang ? ($barang->sub_golongan == $gol->id ? 'selected' : '') : '' }}>
                        {{ $gol->sub_golongan }}</option>
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
            <input type="text" class="form-control" wire:model='golongan' name="" id=""
                placeholder="Masukan Satuan">
            <div class="btn btn-primary btn-sm" wire:click='simpanGolongan'>Simpan</div>
        </div>
    @endif
</div>
