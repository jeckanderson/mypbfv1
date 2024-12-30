<div>
    <div class="flex items-center intro-y mt-8">
        <a href="/pembuatan-sp">
            <button class="mr-2 btn btn-pending btn-sm" wire:ignore>
                <i data-feather="corner-up-left" class="w-4 h-4 mr-1"></i>
                Kembali
            </button>
        </a>
        <h2 class="mr-auto text-lg font-medium text-primary">
            Data Rencana Order
        </h2>
    </div>
    <div class="flex justify-end mt-5 align-end" wire:ignore>
        <flex class="flex gap-2 mr-auto">
            {{-- <label for="horizontal-form-1" class="inline-block mt-2 mb-2 font-bold sm:w-52">
                Supplier
            </label> --}}
            <select id="supplier-select" wire:model.live="cari" class="tom-select w-56">
                <option value="sm:w-full">- Pilih Supplier -</option>
                @forelse ($supliers as $sup)
                    <option value="{{ $sup->id }}">{{ $sup->nama_suplier }}</option>
                @empty
                    <option value="">Tidak ada suplier tersedia</option>
                @endforelse
            </select>
            <button onclick="location.reload()" class="ml-2 btn btn-md btn-secondary" wire:ignore>
                <i data-feather="refresh-cw" class="w-4 h-4 mr-1"></i> Reload
            </button>
        </flex>
    </div>

    <!-- BEGIN: Data List -->
    <div id="supplier-list">
        @forelse ($dataSupplier as $sup)
            <div class="col-span-12 mt-2 overflow-auto intro-y lg:overflow-visible supplier-item"
                data-supplier-id="{{ $sup->id }}" wire:key="sup{{ $loop->index }}">
                <div class="p-2 box">
                    <!-- modal buat sp -->
                    <div id="buat-sp{{ $sup->id }}" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <livewire:pembuatan-sp.rencana-order.buat-sp :sup="$sup"
                                wire:key="buat-sp-{{ $sup->id }}" wire:init="initializeComponent" />
                        </div>
                    </div>
                    <!-- end modal buat sp -->

                    <!-- modal tambah produk -->
                    <div id="tambah-produk{{ $sup->id }}" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <livewire:pembuatan-sp.rencana-order.modal-tambah-produk :nama_suplier="$sup->nama_suplier" :id="$sup->id"
                                wire:key="tambah-produk-modal-{{ $sup->id }}" />
                        </div>
                    </div>
                    <!-- end modal tambah produk -->
                    <div>
                        <livewire:pembuatan-sp.rencana-order.table-order :nama_suplier="$sup->nama_suplier" :sup="$sup"
                            wire:key="table-order-{{ $sup->id }}" wire:init="initializeComponent" />
                    </div>

                </div>
            </div>
        @empty
            <div class="p-5 mt-5 box">
                <h3 class="m-5 font-bold text-pending text-center">Belum ada data suplier tersedia</h3>
            </div>
        @endforelse

        {{ $dataSupplier->links() }}
    </div>
    <!-- END: Data List -->
    {{-- <script>
        document.getElementById('supplier-select').addEventListener('change', function() {
            var selectedSupplierId = this.value;
            var supplierItems = document.querySelectorAll('.supplier-item');

            supplierItems.forEach(function(item) {
                if (selectedSupplierId === '' || item.getAttribute('data-supplier-id') ===
                    selectedSupplierId) {
                    item.style.display = 'block'; // Show matching suppliers
                } else {
                    item.style.display = 'none'; // Hide non-matching suppliers
                }
            });
        });
    </script> --}}
</div>
