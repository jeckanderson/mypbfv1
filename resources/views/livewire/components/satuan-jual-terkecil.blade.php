<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Satuan Jual Terkecil</label>
    <div class="flex w-full gap-1">
        <select id="input-satuan-terkecil{{ $id ?? 0 }}" class="form-select" required name="satuan_jual_terkecil">
            <option value="">- Pilih -</option>
            @if ($satuans->isNotEmpty())
                @foreach ($satuans as $satuan)
                    <option value="{{ $satuan->id }}"
                        {{ $barang ? ($barang->satuan_jual_terkecil == $satuan->id ? 'selected' : '') : '' }}>
                        {{ $satuan->satuan }}</option>
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
            <input type="text" class="form-control" wire:model='satuan' name="" id=""
                placeholder="Masukan Satuan">
            <div class="btn btn-primary btn-sm" wire:click='simpanSatuan'>Simpan</div>
        </div>
    @endif
</div>
