<div>
    @php
        use App\Models\DiskonKelompok;
        use App\Models\Satuan;
    @endphp
    @if ($stok || $pembelian)
        <div class="col-span-12 mt-5 intro-y lg:col-span-6">
            <div class="intro-y box">
                <div
                    class="flex flex-col items-center p-5 text-white border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                    <ul class="flex-col justify-center text-center text-white nav nav-link-tabs sm:flex-row lg:justify-start"
                        role="tablist">
                        @forelse ($kelompoks as $kelompok)
                            <li id="pane{{ $kelompok->id }}-tab" class="nav-item" role="presentation"> <a
                                    href="javascript:;" class="py-4 nav-link {{ $loop->first ? 'active' : '' }}"
                                    data-tw-target="#pane{{ $kelompok->id }}" aria-controls="pane{{ $kelompok->id }}"
                                    aria-selected="{{ $loop->first ? 'active' : 'false' }}" role="tab">
                                    <h3 class="text-base font-medium">Harga Jual
                                        {{ $kelompok->kelompok }}</h3>
                                </a> </li>
                        @empty
                            <li id="tasks-tab" class="nav-item" role="presentation"> <a href="javascript:;"
                                    class="py-4 nav-link" data-tw-target="#tasks" aria-controls="tasks"
                                    aria-selected="false" role="tab">
                                    <h3>Tidak ada kelompok tersedia</h3>
                                </a> </li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-5 intro-y tab-content">
                    @forelse ($kelompoks as $kelompok)
                        <div id="pane{{ $kelompok->id }}" class="tab-pane {{ $loop->first ? 'active' : '' }}"
                            role="tabpanel" aria-labelledby="pane{{ $kelompok->id }}-tab">
                            @forelse (DiskonKelompok::where('id_kelompok', $kelompok->id)->where('satuan_dasar_beli','!=',null)->where('id_obat_barang', $stok->id_obat_barang??$pembelian->id_produk)->get() as $disc)
                                <div class="intro-y box">
                                    <div class="flex gap-4 p-5">
                                        <div class="col-span-12 intro-y sm:col-span-6">
                                            <label for="input-wizard-6" class="form-label">Satuan Jual
                                                {{ $loop->iteration }}</label>
                                            <input id="input-wizard-3" type="text" class="form-control"
                                                placeholder=""
                                                value="{{ Satuan::find($disc->satuan_dasar_beli)->satuan }}"
                                                placeholder="Untuk satuan" readonly>
                                        </div>
                                        <div class="col-span-12 intro-y sm:col-span-6">
                                            <label for="input-wizard-3" class="form-label">Isi</label>
                                            <div class="flex gap-2">
                                                <input id="input-wizard-3" type="text" class="form-control" readonly
                                                    placeholder="" value="{{ $disc->isi }}">
                                                <p class="mt-2 font-bold text-primary">
                                                    {{ $stok->produk->satuanTerkecil->satuan ?? $pembelian->produk->satuanTerkecil->satuan }}
                                                </p>
                                            </div>
                                        </div>
                                        @php
                                            $id_hpp_final = $kelompok->id . $disc->id_set_harga;
                                        @endphp
                                        <div class="col-span-12 intro-y ">
                                            <label for="input-wizard-3"
                                                class="form-label">Modal/{{ Satuan::find($disc->satuan_dasar_beli)->satuan }}
                                                <span class="text-sm text-primary">*5 angka dibelakang
                                                    koma</span></label></label>
                                            <input id="hpp_final{{ $id_hpp_final }}" type="text"
                                                class="form-control" readonly placeholder=""
                                                value="{{ $stok ? number_format((str_replace('.', '', $stok->hpp) / $stok->produk->isi) * $disc->isi, 0, ',', '.') : number_format($hppFinalPembelian * $disc->isi, 5, ',', '.') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="w-full overflow-auto">
                                        @for ($i = 1; $i <= 1; $i++)
                                            @php
                                                $id_item = $kelompok->id . $disc->id_set_harga . $i;
                                                if ($stok) {
                                                    $hpp_final =
                                                        (str_replace('.', '', $stok->hpp) / $stok->produk->isi) *
                                                        $disc->isi;
                                                } elseif ($pembelian) {
                                                    $hpp_final = $hppFinalPembelian * $disc->isi;
                                                }
                                                $persentase = $disc->persentase;
                                                $disc_1 = $disc->disc_1;
                                                $disc_2 = $disc->disc_2;
                                                $hasil_laba = round($hpp_final * (1 + $persentase / 100));
                                                $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                                                $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                                            @endphp
                                            {{-- hidden input --}}
                                            <input type="hidden" value="{{ $pembelian->id ?? $stok->id }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][id_set_harga]">
                                            <input type="hidden" value="{{ app('request')->input('sumber') }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][sumber]"
                                                wire:model='sumber'>
                                            <input type="hidden" value="{{ $kelompok->id }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][id_kelompok]">
                                            <input type="hidden" value="{{ $disc->id_set_harga }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][id_set]">
                                            <input type="hidden" value="{{ $i }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][id_jumlah]">
                                            <input type="hidden" value="{{ $disc->satuan_dasar_beli }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][satuan_terkecil]">
                                            <input type="hidden"
                                                value="{{ $stok ? number_format((str_replace('.', '', $stok->hpp) / $stok->produk->isi) * $disc->isi, 0, ',', '.') : number_format($hppFinalPembelian * $disc->isi, 5, ',', '.') }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][hpp_final]">
                                            <input type="hidden" value="{{ $disc->isi }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][isi]">
                                            <input type="hidden" value="{{ $disc->id_obat_barang }}"
                                                name="sets[{{ $id_hpp_final }},{{ $id_item }}][id_produk]">
                                            {{-- end hidden input --}}
                                            <div class="flex items-center w-full flex-nowrap">
                                                {{-- <div class="flex items-center mb-4 mr-4">
                                                    <label for="jumlah" class="w-32 mr-2">Jumlah
                                                        {{ $i }}</label>
                                                    <input pattern="[0-9,.]*" inputmode="decimal" id="jumlah"
                                                        type="number"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][jumlah]"
                                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                </div>
                                                <div class="flex items-center mb-4 mr-4">
                                                    <label for="sampai" class="w-32 mr-2">Sampai</label>
                                                    <input pattern="[0-9,.]*" inputmode="decimal" id="sampai"
                                                        type="number"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][sampai]"
                                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                </div> --}}
                                                <div class="flex items-center mb-4 mr-4">
                                                    <label for="laba" class="w-32 mr-2">Laba</label>
                                                    <input pattern="[0-9.]*" inputmode="decimal"
                                                        id="laba{{ $id_item }}" type="text"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][laba]"
                                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                                        value="{{ $persentase }}"
                                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number no-coma focus:border-blue-500 focus:outline-none">
                                                    <input pattern="[0-9,.]*" inputmode="decimal" type="text"
                                                        id="hasil-laba{{ $id_item }}"
                                                        value="{{ str_replace(',', '.', number_format($hasil_laba)) }}"
                                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][hasil_laba]"
                                                        class="w-full px-2 py-1 ml-2 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                </div>
                                                <div class="flex items-center mb-4 mr-4">
                                                    <label for="disc_1" class="w-32 mr-2">Disc 1</label>
                                                    <input pattern="[0-9,.]*" inputmode="decimal"
                                                        id="disc_1{{ $id_item }}" type="text"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][disc_1]"
                                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                                        value="{{ $disc_1 }}"
                                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                </div>
                                                <div class="flex items-center mb-4 mr-4">
                                                    <label for="disc_2" class="w-32 mr-2">Disc 2</label>
                                                    <input pattern="[0-9,.]*" inputmode="decimal"
                                                        id="disc_2{{ $id_item }}" type="text"
                                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][disc_2]"
                                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                                        value="{{ $disc_2 }}"
                                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                </div>
                                                <div class="flex items-center mb-4 mr-4">
                                                    <div class="flex items-center">
                                                        <label for="harga-jual" class="w-32 mr-2">Harga Jual</label>
                                                        <input pattern="[0-9,.]*" inputmode="decimal"
                                                            id="harga-jual{{ $id_item }}" type="text"
                                                            readonly
                                                            value="{{ str_replace(',', '.', number_format($harga_jual)) }}"
                                                            name="sets[{{ $id_hpp_final }},{{ $id_item }}][harga_jual]"
                                                            class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                                        <div id="hppFinalMessage{{ $id_item }}"
                                                            class="text-sm text-red-500">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end align-item-end">
                                                <p id="message" class="text-danger" style="display: none;">
                                                    Harga Jual akan mengalami kerugian, yakin?
                                                </p>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @empty
                                kosong
                            @endforelse
                        </div>
                    @empty
                        <div class="card">
                            <div class="font-bold text-center text-pending card-body">
                                <h2>Belum ada data kelompok tersedia</h2>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
