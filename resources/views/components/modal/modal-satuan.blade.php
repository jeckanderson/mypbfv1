<div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-10">
                <div class="preview">
                    <form action="{{ route($route, ['id' => $id]) }}" method="POST">
                        @csrf
                        <div>
                            <label for="vertical-form-1" class="form-label font-medium text-primary">Nama
                                Satuan</label>
                            <input id="vertical-form-1" type="text" name="satuan" class="form-control"
                                placeholder="" value="{{ $satuan ? $satuan->satuan : '' }}" required>
                        </div>
                        <button class="btn btn-primary mt-5">Simpan</button>
                        <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
