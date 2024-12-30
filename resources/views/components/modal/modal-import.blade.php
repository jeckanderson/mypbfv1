<div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="rounded-lg modal-dialog">
        <form action="{{ route($route, ['id' => $id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="flex justify-center text-white modal-header bg-primary align-center">
                    <h2 class="text-lg font-bold">Import</h2>
                </div>
                <div class="p-10 modal-body">
                    <a href="{{ asset('import/' . $filename) }}" class="btn btn-primary btn-sm" download>Download
                        Format</a>
                    <div class="preview">
                        <div data-tw-merge class="items-center block mt-3">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-40">
                                Import File
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="file" placeholder="" name="file"
                                required class="form-control" />
                        </div>
                    </div>
                </div>
                {{-- footer --}}
                <div class="modal-footer">
                    <button class="mt-5 btn btn-primary" type="submit">Simpan</button>
                    <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
