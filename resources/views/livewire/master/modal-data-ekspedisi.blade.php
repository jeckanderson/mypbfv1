<div class="modal-content">
    <div class="modal-header border-b border-gray-200 dark:border-gray-700 pb-4">
        <h2 class="text-lg text-primary font-semibold text-gray-900 dark:text-gray-100">Ekspedisi</h2>
    </div>
    <div class="modal-body p-5">
        <div class="preview">
            <div class="form-group">
                <label for="nama-ekspedisi" class="form-label">Nama Ekspedisi</label>
                <input id="nama-ekspedisi" type="text" class="form-control" placeholder="" wire:model='nama_ekspedisi'>
            </div>
            <div class="form-group mt-3">
                <label for="plat-no-armada" class="form-label">Plat No. Armada</label>
                <input id="plat-no-armada" type="text" class="form-control" placeholder="" wire:model='nomor'>
            </div>
            <div class="mt-5 d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" data-tw-dismiss="modal" wire:click='simpanEkspedisi'>
                    Simpan
                </button>
                <button class="btn btn-outline-danger" data-tw-dismiss="modal" type="button">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
