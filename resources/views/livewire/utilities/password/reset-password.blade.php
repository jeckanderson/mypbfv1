<form wire:submit.prevent="renewPassword">
    @if (session()->has('success'))
        <div class="flex items-center mt-2 mb-2 alert alert-primary show" role="alert">
            {{ session('success') }}
            <button wire:ignore id="closeAlert" class="ml-auto" onclick="closeAlert()">
                <i data-feather="x-circle" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="flex items-center mt-2 mb-2 alert alert-danger show" role="alert" wire:ignore>
            {{ session('error') }}
            <button id="closeAlert" class="ml-auto" onclick="closeAlert()">
                <i data-feather="x-circle" class="w-4 h-4"></i>
            </button>
        </div>
    @endif
    <div class="p-5 mt-5 box">
        <h3 class="mb-5 text-lg font-bold text-primary">Perbarui Password Harga</h3>
        <div class="mb-3">
            <label for="vertical-form-1" class="font-medium form-label">Password Baru</label>
            <input id="vertical-form-1" wire:model='password' type="password" name="satuan" class="form-control"
                placeholder="" required>
        </div>
        <div class="mb-3">
            <label for="vertical-form-1" class="font-medium form-label">Konfirmasi Password</label>
            <input id="vertical-form-1" wire:model='passwordConfirmation' type="password" name="satuan"
                class="form-control" placeholder="" required>
        </div>
        <div class="flex gap-3">
            <button class="mt-5 btn btn-primary">Perbarui Password</button>
        </div>
    </div>
</form>

<script>
    function closeAlert() {
        var alert = document.querySelector('.alert');
        alert.style.display = 'none';
    }
</script>
