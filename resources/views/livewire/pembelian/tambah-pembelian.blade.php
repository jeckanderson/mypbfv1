<div>
    @php
        use App\Models\RencanaOrder;
        use App\Models\Pembelian;
        use App\Models\PPN;
        use Picqer\Barcode\BarcodeGeneratorHTML;
        $pajakPPN = PPN::where('id_perusahaan', Auth::user()->id_perusahaan)->first();
        $generator = new BarcodeGeneratorHTML();
    @endphp
    <form wire:submit="buatPembelian">
        @if (!$pajakPPN)
            <div class="flex items-center mt-2 mb-2 alert alert-warning show" role="alert">
                <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i>
                <p>PPN anda belum di atur, klik <a href="/pajak-perusahaan" class="font-bold">disini</a> untuk mengatur
                    PPN
                    dan melanjutkan penambahan pembelian
                </p>
            </div>
        @else
            <div class="grid-cols-3 gap-4 mt-1 sm:grid">
                <div class="p-2 box drop-shadow">
                    <div data-tw-merge class="items-center block mt-3 wire:ignore sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Reff SP
                        </label>
                        <select class="font-bold form-control tom-select" wire:model.live='suratPesanan'>
                            <option value="">- Pilih -</option>
                            @forelse ($pesanans as $pesanan)
                                <option value="{{ $pesanan->id }}">{{ $pesanan->no_reff }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. SP
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                            wire:model='no_sp' class="form-control" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tgl. Input
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                            value="{{ now()->format('Y-m-d') }}" disabled wire:model='tgl_input' class="form-control" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Tgl. Faktur
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                            wire:model='tgl_faktur' class="form-control" />
                    </div>
                    <div class="mt-1">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="checkbox-switch-7">Inc PPN</label>
                            <input id="checkbox-switch-7" class="mx-3 form-check-input" type="checkbox"
                                wire:model.live='inc_ppn'>
                        </div>
                    </div>
                </div>
                <div class="box mt-2 mb-5 text-center">
                    @php
                        $urutan = str_pad(Pembelian::count() + 1, 6, '0', STR_PAD_LEFT);
                    @endphp
                    <div class="mt-2">
                        <label for="no-reff" class="form-label font-bold">No. Reff</label>
                        <input type="text" class="font-bold text-center text-pending form-control" disabled
                            name="" id="" placeholder="Auto" wire:model='no_reff'>
                    </div>
                    <div class="flex justify-center mt-3 align-center">
                        @if ($no_reff)
                            {!! $generator->getBarcode($no_reff, $generator::TYPE_CODE_128) !!}
                        @endif
                    </div>
                </div>
                <div class="p-2 box">
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Supplier
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" disabled
                            wire:model='suplier' class="form-control" />
                    </div>
                    <div data-tw-merge class="items-center block mt-1 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No Faktur
                        </label>
                        <input data-tw-merge id="horizontal-form-1" type="text" placeholder="" wire:model='no_faktur'
                            required class="font-bold form-control" />
                    </div>
                    <div data-tw-merge class="flex items-center block gap-2 mt-1">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Kredit
                        </label>
                        <div class="flex w-full gap-2 gap-3">
                            <div class="form-check form-switch">
                                <input id="checkbox-switch-7" class="mx-3 form-check-input" type="checkbox"
                                    wire:model.live="active" {{ $total_hutang != 0 ? 'required' : '' }}>
                            </div>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder="Hari..."
                                {{ $disabled }} class="w-20 form-control" wire:model.live='hari'
                                {{ $total_hutang != 0 ? 'required' : '' }} />
                            <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                                {{ $disabled }} class="form-control"
                                value="{{ $tgl_tempo_kredit ? $tgl_tempo_kredit : '' }}"
                                wire:model.live='tgl_tempo_kredit' />
                        </div>
                    </div>
                    <div>
                        <h4 class="border p-3 mt-2 mb-2 text-4xl font-bold font-medium box text-pending text-right">
                            {{ number_format($total_hutang, 0, ',', '.') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-span-12 mt-1 overflow-auto intro-y lg:overflow-visible">
                <div class="gap-3 mb-3 sm:flex ">
                    @if (!$id)
                        {{-- <div class="mr-auto" wire:ignore>
                            <label for="" class="mt-2 text-pending ">*Pilih SP Pembelian terlebih
                                dahulu</label>
                            <div class="flex gap-3">
                                <select class="w-64 form-control tom-select" wire:model.live='suratPesanan'>
                                    <option value="">- Pilih -</option>
                                    @forelse ($pesanans as $pesanan)
                                        <option value="{{ $pesanan->id }}">{{ $pesanan->no_reff }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div> --}}
                        {{-- modal surat pesanan --}}
                        <div id="surat-pesanan" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <livewire:pembelian.tambah-pembelian.dari-sp>
                            </div>
                        </div>
                    @endif

                    {{-- <div>
                        <h2 class="p-3 mt-2 mb-2 text-4xl font-bold box text-pending">Total:
                            {{ number_format($total_hutang, 0, ',', '.') }}
                        </h2>
                    </div> --}}
                </div>
            </div>
            <div class="mt-2 overflow-auto box">
                <table class="table">
                    <style>
                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }
                    </style>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            margin: 20px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin: 20px 0;
                        }

                        td {
                            padding: 3px;
                            text-align: left;
                        }

                        .border {
                            border: 1px solid #bbb;
                            /* Contoh warna abu-abu untuk border */
                        }

                        .header-gray {
                            background-color: #e0e0e0;
                            /* Contoh warna abu-abu */
                            color: black;
                            /* Warna teks hitam */
                        }

                        th {
                            font-weight: bold;
                            text-align: center;
                        }

                        td {
                            font-size: 1em;
                        }

                        .col-no {
                            width: 3%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-total {
                            width: 10%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-dis1 {
                            width: 7%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-dis2 {
                            width: 7%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-qtyfaktur {
                            width: 10%;
                            /* Atur lebar sesuai kebutuhan */
                        }

                        .col-harga {
                            width: 15%;
                            /* Atur lebar sesuai kebutuhan */
                        }
                    </style>
                    <thead>
                        <tr class="header-gray">
                            <th class="border border-slate-600 col-no">No</th>
                            <th class="border border-slate-600">Nama Produk</th>
                            <th class="border border-slate-600">Satuan</th>
                            <th class="border border-slate-600">Qty SP</th>
                            <th class="border border-slate-600 col-qtyfaktur">Qty Faktur</th>
                            <th class="border border-slate-600 col-harga">Harga</th>
                            <th class="border border-slate-600 col-dis1">Disc % 1</th>
                            <th class="border border-slate-600 col-dis2">Disc % 2</th>
                            <th class="border border-slate-600 col-total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($surat)
                            @if ($produk_pembelian)
                                @foreach ($produk_pembelian as $index => $prod)
                                    <tr>
                                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                        <td class="border border-slate-600">
                                            {{ $prod->order->produk->nama_obat_barang }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ $prod->order->produk->satuanDasar->satuan }}
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ $prod->order->jumlah_order }}</td>
                                        <td class="border border-slate-600">
                                            <input type="number" required class="form-control" min="0"
                                                wire:model.live.lazy="counts.{{ $index }}.qty"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'qty')">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" required class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.harga"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'harga')"
                                                oninput="formatNumber(this)">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.disc1"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'disc1')"
                                                onkeyup="return checkInput(event,'0123456789.',this)">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.disc2"
                                                onkeyup="return checkInput(event,'0123456789.',this)"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'disc2')">
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ number_format($counts[$index]['total'] ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @foreach (RencanaOrder::whereIn('id', json_decode($surat->id_order))->get() as $index => $order)
                                    <tr>
                                        <td class="border border-slate-600">{{ $loop->iteration }}</td>
                                        <td class="border border-slate-600">{{ $order->produk->nama_obat_barang }}
                                        </td>
                                        <td class="border border-slate-600">{{ $order->produk->satuanDasar->satuan }}
                                        </td>
                                        <td class="border border-slate-600">{{ $order->jumlah_order }}</td>
                                        <input type="hidden" value="{{ $order->produk->isi }}"
                                            wire:model='counts.{{ $index }}.isi'>
                                        <td class="border border-slate-600">
                                            <input type="number" required class="form-control" min="0"
                                                wire:model.live.lazy="counts.{{ $index }}.qty"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'qty')">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" required class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.harga"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'harga')"
                                                oninput="formatNumber(this)">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.disc1"
                                                onkeyup="return checkInput(event,'0123456789.',this)"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'disc1')">
                                        </td>
                                        <td class="border border-slate-600">
                                            <input type="text" class="form-control"
                                                wire:model.live.lazy="counts.{{ $index }}.disc2"
                                                onkeyup="return checkInput(event,'0123456789.',this)"
                                                wire:change="calculateTotal({{ $index }}, $event.target.value, 'disc2')">
                                        </td>
                                        <td class="border border-slate-600">
                                            {{ number_format($counts[$index]['total'] ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @else
                            <tr>
                                <td class="font-bold text-center border text-pending border-slate-600" colspan="9">
                                    Belum
                                    ada SP
                                    yang dipilih
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="p-2 mt-2 box">
                <div class="grid-cols-2 gap-5 sm:grid">
                    <div class="">
                        <div data-tw-merge class="items-center block mt-3 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Sub Total
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                value="{{ number_format($subtotal, 0, ',', '.') }}" disabled class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Disc
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    wire:model.live.debounce.500ms='diskon' class="form-control" />
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    value="{{ number_format($hasil_diskon, 0, ',', '.') }}" disabled
                                    class="form-control" />
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                DPP
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                value="{{ number_format($dpp, 0, ',', '.') }}" disabled class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                PPN
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                value="{{ number_format($ppn, 0, ',', '.') }}" disabled class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-2" class="inline-block mb-2 sm:w-60">
                                Biaya 1
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-2" type="text" placeholder=""
                                    wire:model.live.debounce.500ms='biaya1' oninput="formatNumber(this)"
                                    class="form-control" />

                                <select data-tw-merge aria-label="Default select example" class="form-control"
                                    {{ $biaya1 != 0 ? 'required' : '' }} wire:model='akun_biaya1'>
                                    <option value="">- Pilih Akun -</option>
                                    @forelse ($akuns2 as $akun)
                                        <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                    @empty
                                        <!-- Tindakan jika data tidak ditemukan -->
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Biaya 2
                            </label>
                            <div class="flex w-full gap-2">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    wire:model.live.debounce.500ms='biaya2' oninput="formatNumber(this)"
                                    class="form-control" />

                                <select data-tw-merge aria-label="Default select example" class="form-control"
                                    wire:model='akun_biaya2' {{ $biaya2 != 0 ? 'required' : '' }}>
                                    <option value="">- Pilih Akun -</option>
                                    @forelse ($akuns2 as $akun)
                                        <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                    @empty
                                        <!-- Tindakan jika data tidak ditemukan -->
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Total
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                value="{{ number_format($total_tagihan, 0, ',', '.') }}" disabled
                                class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-2" class="inline-block mb-2 sm:w-60">
                                Akun Bayar
                            </label>
                            <select data-tw-merge aria-label="Default select example" class="form-control"
                                wire:model='akun_bayar' {{ $jumlah_bayar != 0 ? 'required' : '' }}>
                                <option value="">- Pilih -</option>
                                @forelse ($akuns->where('kas_bank', 1) as $akun)
                                    <option value="{{ $akun->kode }}">{{ $akun->nama_akun }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Jumlah Bayar
                            </label>
                            <div class="w-full">
                                <input data-tw-merge id="horizontal-form-1" type="text" placeholder=""
                                    oninput="formatNumber(this)" wire:model.live='jumlah_bayar'
                                    class="form-control" />
                                @if ($total_hutang < 0)
                                    <p class="mt-2 text-danger">Jumlah yang anda masukan terlalu besar dari total
                                        tagihan</p>
                                @endif
                            </div>
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                No Seri Pajak
                            </label>
                            <input data-tw-merge id="formattedInput" type="text" placeholder="000.14.12345678"
                                wire:model='no_faktur_pajak' class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Tgl Faktur Pajak
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                                wire:model='tgl_faktur_pajak' class="form-control" />
                        </div>
                        <div data-tw-merge class="items-center block mt-1 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Kompensasi Pajak
                            </label>
                            <input data-tw-merge id="horizontal-form-1" type="date" placeholder=""
                                wire:model='kompensasi_pajak' class="form-control" />
                        </div>
                    </div>
                </div>
                <div data-tw-merge class="items-center block mt-2 sm:flex">
                    <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-52">
                        Keterangan
                    </label>
                    <textarea data-tw-merge id="horizontal-form-1" type="text" placeholder="" rows="4" wire:model='keterangan'
                        class="form-control">
                    </textarea>
                </div>

                @if ($akses)
                    <div class="flex justify-center gap-2 mt-5">
                        <button class="btn btn-primary" wire:loading.remove type="submit">Simpan</button>
                        <button wire:loading class="btn btn-primary" disabled>
                            Menyimpan...
                        </button>
                        <a href="/pembelian" class="btn btn-outline-danger">Batal</a>
                    </div>
                @endif
            </div>
        @endif
    </form>
    <script>
        function formatNumber(input) {
            input.value = input.value.replace(/[^\d.]/g, '');

            let number = parseFloat(input.value.replace(/\./g, '').replace(',', '.')).toFixed(0);
            input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
        }

        function formatDisc(input) {
            input.value = input.value.replace(/[^\d.]/g, '');

            let number = parseFloat(input.value.replace(/\./g, '').replace(',', '')).toFixed(0);
            input.value = isNaN(number) ? '0' : new Intl.NumberFormat('id-ID').format(number);
        }

        function parseFormattedValue(value) {
            return value.replace(/\./g, '');
        }

        const inputElement = document.getElementById('formattedInput');

        function formatPajak() {
            let value = inputElement.value.replace(/\D/g, '');
            if (value.length > 13) {
                value = value.slice(0, 13);
            }
            ft

            value = value.replace(/^(\d{3})(\d{2})/, "$1.$2.");

            inputElement.value = value;
        }
        inputElement.addEventListener('input', formatPajak);

        function checkInput(e, chars, field) {
            let teks = field.value;
            let teksSplit = teks.split("");
            let teksOke = [];
            for (let i = 0; i < teksSplit.length; i++) {
                if (chars.indexOf(teksSplit[i]) != -1) {
                    teksOke.push(teksSplit[i]);
                }
            }
            field.value = teksOke.join("");
        }
    </script>
</div>
