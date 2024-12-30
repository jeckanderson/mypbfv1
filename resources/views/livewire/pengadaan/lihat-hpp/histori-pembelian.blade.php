<div>
    @php
        use App\Models\ProdukPembelian;
        use App\Models\PPN;
    @endphp
    <div class="grid grid-cols-12 gap-6 mt-5">
        <a href="/defecta"><button class="mr-2 btn btn-pending"><i data-feather="corner-up-left" class="w-4 h-4 mr-1"></i>
                Kembali</button></a>
        <!-- BEGIN: Data List -->
        <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
            <table class="table -mt-2 table-report">
                <thead style="background-color: #d3d3d3;">
                    <tr>
                        <th class="whitespace-nowrap">Satuan Beli</th>
                        <th class="whitespace-nowrap">Nama Produk</th>
                        <th class="whitespace-nowrap">Harga Beli</th>
                        <th class="whitespace-nowrap">Disc 1</th>
                        <th class="whitespace-nowrap">Disc 2</th>
                        <th class="whitespace-nowrap">Isi</th>
                        <th class="whitespace-nowrap">Satuan Terkecil</th>
                        <th class="whitespace-nowrap">HPP Final</th>
                        <th class="whitespace-nowrap">Tgl Faktur</th>
                        <th class="whitespace-nowrap">Supplier</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembelians as $pembelian)
                        @php
                            $hppSatuan = $pembelian->total / $pembelian->qty_faktur / $pembelian->order->produk->isi;
                            //mencari jumlah kesuluruhan isi
                            $id_sp = $pembelian->id_sp;
                            $totalIsi = 0;

                            foreach (ProdukPembelian::where('id_sp', $id_sp)->get() as $get) {
                                $totalIsi += $get->order->produk->isi * $pembelian->qty_faktur;
                            }
                            $pengurang = round($pembelian->pembelian->hasil_diskon / $totalIsi);
                            $hppFinalPembelian = $hppSatuan - $pengurang;
                            if ($pembelian->inc_ppn == 1) {
                                $hppFinalPembelian = round(
                                    $hppFinalPembelian /
                                        (1 +
                                            PPN::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->ppn /
                                                100),
                                );
                            }
                        @endphp
                        <tr class="intro-x">
                            <td class="">{{ $pembelian->order->produk->satuanDasar->satuan }}</td>
                            <td class="">{{ $pembelian->order->produk->nama_obat_barang }}</td>
                            <td class="">{{ $pembelian->harga }}</td>
                            <td class="">{{ $pembelian->disc_1 }} %</td>
                            <td class="">{{ $pembelian->disc_2 }} %</td>
                            <td class="">{{ $pembelian->order->produk->isi }}</td>
                            <td class="">{{ $pembelian->order->produk->satuanTerkecil->satuan }}</td>
                            <td class="">{{ number_format($hppFinalPembelian, 0, ',', '.') }}</td>
                            <td class="">{{ date('d-m-Y', strtotime($pembelian->pembelian->tgl_faktur)) }}</td>
                            <td class="font-bold text-pending">{{ $pembelian->pembelian->getSuplier->nama_suplier }}
                            </td>
                            <td class="w-32"><button class="btn btn-outline-primary btn-sm" data-tw-toggle="modal"
                                    data-tw-target="#modal-order{{ $pembelian->id }}">order +</button>
                            </td>
                            {{-- modal start --}}
                            <div id="modal-order{{ $pembelian->id }}" class="modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <livewire:pengadaan.lihat-hpp.modal-tambah-order :produk="$pembelian->order->produk"
                                        :pembelian="$pembelian->pembelian" />
                                </div>
                            </div>
                            {{-- modal end --}}
                        </tr>
                    @empty
                        <tr class="intro-x">
                            <td class="font-bold text-pending text-center" colspan="12">Belum ada data pembelian
                                tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Data List -->
    </div>
</div>
