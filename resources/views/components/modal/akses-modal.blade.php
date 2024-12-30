<div id="{{ $id_modal }}" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="text-lg text-center text-primary align-center">Tambahkan Akses User</h1>
            </div>
            <div class="px-5 modal-body">
                <form action="{{ route($route, $role ? ['id' => $role->id] : '') }}" method="POST">
                    @csrf
                    <div class="flex gap-3 mb-3">
                        <label for="vertical-form-1" class="w-32 mt-2 form-label">Nama Akses</label>
                        <input required name="role" id="vertical-form-1" type="text" class="form-control"
                            placeholder="Isikan nama role akses" value="{{ $role ? $role->name : '' }}">
                    </div>
                    <div class="overflow-auto">
                        <table class="table border">
                            <thead>
                                <tr>
                                    <td
                                        class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                        <div data-tw-merge class="flex items-center mt-2">
                                            <input data-tw-merge type="checkbox" class="w-5 transition-all form-control"
                                                id="checkbox-switch-akses" value="" onchange="checkAkses(this)" />
                                            <label data-tw-merge for="checkbox-switch-akses"
                                                class="ml-2 cursor-pointer">Akses</label>
                                        </div>
                                    </td>
                                    <td
                                        class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                        Nama Akses</td>
                                    <td
                                        class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                        <div data-tw-merge class="flex items-center mt-2">
                                            <input data-tw-merge type="checkbox" class="w-5 transition-all form-control"
                                                id="checkbox-switch-tambah" value=""
                                                onchange="checkTambah(this)" />
                                            <label data-tw-merge for="checkbox-switch-tambah"
                                                class="ml-2 cursor-pointer">Tambah</label>
                                        </div>
                                    </td>
                                    <td
                                        class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                        <div data-tw-merge class="flex items-center mt-2">
                                            <input data-tw-merge type="checkbox" class="w-5 transition-all form-control"
                                                id="checkbox-switch-aksi" value="" onchange="checkAksi(this)" />
                                            <label data-tw-merge for="checkbox-switch-aksi"
                                                class="ml-2 cursor-pointer">Aksi</label>
                                        </div>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    @if (strpos($permission, 'akses_') === 0)
                                        <tr>
                                            <td
                                                class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                                <input data-tw-merge type="checkbox" name="permissions[]"
                                                    class="w-5 transition-all group-akses form-control"
                                                    id="checkbox-switch-{{ $key }}" value="{{ $permission }}"
                                                    {{ $role ? ($role->hasPermissionTo($permission) ? 'checked' : '') : '' }} />
                                            </td>
                                            <td
                                                class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                                {{ Str::title(str_replace('_', ' ', $permission)) }}
                                            </td>
                                            <td
                                                class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                                @php
                                                    $tambah = str_replace('akses_', 'tambah_', $permission);
                                                    $hasTambah = in_array($tambah, $permissions->toArray());
                                                @endphp
                                                @if ($hasTambah)
                                                    <input data-tw-merge type="checkbox" name="permissions[]"
                                                        class="w-5 transition-all group-tambah form-control"
                                                        id="checkbox-switch-tambah-{{ $key }}"
                                                        value="{{ $tambah }}"
                                                        {{ $role && $role->hasPermissionTo($tambah) ? 'checked' : '' }} />
                                                @endif
                                            </td>
                                            <td
                                                class="border-t border-b-2 border-l border-r dark:border-darkmode-300 whitespace-nowrap">
                                                @php
                                                    $aksi = str_replace('akses_', 'aksi_', $permission);
                                                    $hasAksi = in_array($aksi, $permissions->toArray());
                                                @endphp
                                                @if ($hasAksi)
                                                    <input data-tw-merge type="checkbox" name="permissions[]"
                                                        class="w-5 transition-all group-aksi form-control"
                                                        id="checkbox-switch-aksi-{{ $key }}"
                                                        value="{{ $aksi }}"
                                                        {{ $role && $role->hasPermissionTo($aksi) ? 'checked' : '' }} />
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="mt-5 btn btn-primary"> Simpan </button>
                        <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button"> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkAkses(box) {
        let checkboxes = document.querySelectorAll('input.group-akses');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = box.checked;
        });
    }

    function checkTambah(box) {
        let checkboxes = document.querySelectorAll('input.group-tambah');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = box.checked;
        });
    }

    function checkAksi(box) {
        let checkboxes = document.querySelectorAll('input.group-aksi');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = box.checked;
        });
    }
</script>
