<form wire:submit.prevent="simpanNoFaktur">
    @if (session()->has('success'))
        <div class="flex items-center mt-2 mb-2 alert alert-primary show" role="alert">
            {{ session('success') }}
            <button id="closeAlert" class="ml-auto" onclick="closeAlert()">
                <i data-feather="x-circle" class="w-4 h-4"></i>
            </button>
        </div>
        <script>
            function closeAlert() {
                var alert = document.querySelector('.alert');
                alert.style.display = 'none';
            }
        </script>
    @endif
    <div class="p-5 mt-5 box">
        <div class="flex gap-5 align-middle">
            <p class="mt-2">000001 /</p>
            <input type="text" class="w-48 text-center form-control" required wire:model="faktur">
            <p class="mt-2">MM-YY</p>
            <button class="btn btn-primary" wire:loading.remove type="submit">Simpan</button>
            <button wire:loading class="btn btn-primary">
                Menyimpan...
            </button>
        </div>
    </div>

    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Setting Footer Faktur Penjualan
        </h2>
    </div>
    <div class="p-5 mt-5 box">
        <div class="flex gap-5 align-middle">
            <input type="text" class="text-center w-xl form-control" required wire:model="footer">
            <div class="btn btn-primary" wire:loading.remove wire:click='simpanFooter'>Simpan</div>
            <button wire:loading class="btn btn-primary">
                Menyimpan...
            </button>
        </div>
    </div>
</form>
