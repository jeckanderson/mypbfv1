<div class="modal-content">
    <div class="flex justify-left modal-header text-primary">
        <h2 class="text-lg font-bold">Nomor Seri Faktur Pajak</h2>
    </div>
    <div class="p-5 modal-body">
        @include('components.alert')
        <div class="preview">
            <div>
                <label for="no_faktur_pajak" class="form-label">No Faktur Pajak</label>
                <input wire:model="no_faktur_pajak" id="no_faktur_pajak" type="text" class="form-control"
                    placeholder="Masukan No Faktur Pajak">
                @error('no_faktur_pajak')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="tgl_faktur_pajak" class="mt-3 form-label">Tanggal Faktur Pajak</label>
                <input wire:model="tgl_faktur_pajak" id="tgl_faktur_pajak" type="date" class="form-control"
                    placeholder="Masukan Tanggal Faktur Pajak">
                @error('tgl_faktur_pajak')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="kompensasi_pajak" class="mt-2 form-label">Kompensasi Pajak</label>
                <input wire:model="kompensasi_pajak" id="kompensasi_pajak" type="date" class="form-control"
                    placeholder="Masukan Kompensasi Pajak">
                @error('kompensasi_pajak')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <button class="mt-5 btn btn-primary" wire:click="save">Simpan</button>
            <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal </button>
        </div>
    </div>
</div>
