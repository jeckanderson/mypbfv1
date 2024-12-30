{{-- @if ($satuans->isNotEmpty())
    @dd('dd edit')
@endif --}}

<div class="col-span-12 intro-y sm:col-span-6">
    <label for="input-wizard-6" class="form-label">Satuan Dasar/Beli</label>
    <div class="flex w-full gap-1">
        <select id="satuan_dasar_beli{{ $id ?? 0 }}" class="form-select" required name="satuan_dasar_beli">
            <option value="">Belum ada data</option>
            {{-- @if ($satuans->isNotEmpty())
                <option value="">- Pilih -</option>
                @foreach ($satuans as $satuan)
                    <option value="{{ $satuan->id }}"
                        {{ $barang ? ($barang->satuan_dasar_beli == $satuan->id ? 'selected' : '') : '' }}>
                        {{ $satuan->satuan }}
                    </option>
                @endforeach
            @else
                <option value="">Belum ada data</option>
            @endif --}}
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
