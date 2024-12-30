<div class="col-span-12 mt-5 intro-y lg:col-span-6">
    @php
        use App\Models\DiskonKelompok;
        use App\Models\SetHarga;
        use App\Models\Satuan;

        // $sets = SetHarga::where('id_set_harga', $id);

    @endphp
    @if ($stok || $pembelian || $opname)
        @foreach (SetHarga::where('id_set_harga', $stok->id ?? ($pembelian->id ?? $opname->id))->where('id_kelompok', $set->id_kelompok)->groupBy('id_set')->where('sumber', $sumber)->get() as $setId)
            <div class="intro-y box">
                <div class="flex gap-4 p-5">
                    <div class="col-span-12 intro-y sm:col-span-6">
                        <label for="input-wizard-6" class="form-label">Satuan Jual
                            {{ $loop->iteration }}</label>
                        <input id="input-wizard-3" type="text" class="form-control" placeholder=""
                            value="{{ $setId->satuanJual->satuan }}" placeholder="Untuk satuan" readonly>
                    </div>
                    <div class="col-span-12 intro-y sm:col-span-6">
                        <label for="input-wizard-3" class="form-label">Isi</label>
                        <div class="flex gap-2">
                            <input id="input-wizard-3" type="text" class="form-control" readonly placeholder=""
                                value="{{ $setId->isi }}">
                            <p class="mt-2 font-bold text-primary">
                                {{ $stok->produk->satuanTerkecil->satuan ?? ($pembelian->produk->satuanTerkecil->satuan ?? $opname->produk->satuanTerkecil->satuan) }}
                            </p>
                        </div>
                    </div>
                    @php
                        $id_hpp_final =
                            $setId->diskonkelompok($set->kelompok->id, $setId->id_set)->id .
                            $setId->diskonkelompok($set->kelompok->id, $setId->id_set)->id_set_harga;
                    @endphp
                    <div class="col-span-12 intro-y ">
                        <label for="input-wizard-3" class="form-label">Modal/{{ $setId->satuanJual->satuan }}
                            <span class="text-sm text-primary">*5 angka dibelakang koma</span></label>
                        <input id="hpp_final{{ $id_hpp_final }}" type="text" class="form-control" readonly
                            placeholder="" value="{{ number_format($setId->hpp_final,5,',','.') }}">
                    </div>
                </div>
                <div class="p-5">
                    <div class="w-full overflow-auto">
                        @for ($i = 1; $i <= 1; $i++)
                            @php
                                $id_item = $setId->id_kelompok . $setId->id_set . $i;
                                $item = $setId->getItem($set->kelompok->id, $setId->id_set, $i);
                                $harga = $setId->hpp_final ;
                                $harga += $harga * ($setId->laba/100);
                            @endphp
                            <div class="flex items-center w-full flex-nowrap">
                                {{-- input hidden --}}
                                <input type="hidden" value="{{ $setId ? $setId->id : '' }}"
                                    name="sets[{{ $id_hpp_final }},{{ $id_item }}][id]">
                                {{-- hidden input --}}
                                <div class="flex items-center mb-4 mr-4">
                                    <label for="laba" class="w-32 mr-2">Laba</label>
                                    <input pattern="[0-9,.]*" inputmode="decimal" id="laba{{ $id_item }}"
                                        type="text" name="sets[{{ $id_hpp_final }},{{ $id_item }}][laba]"
                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                        value="{{ $setId ? $setId->laba : '' }}"
                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md no-coma number focus:border-blue-500 focus:outline-none">
                                    <input pattern="[0-9,.]*" inputmode="decimal" type="text"
                                        id="hasil-laba{{ $id_item }}" value="{{ number_format($harga,0,',','.') }}"
                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][hasil_laba]"
                                        class="w-full px-2 py-1 ml-2 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                </div>
                                <div class="flex items-center mb-4 mr-4">
                                    <label for="disc_1" class="w-32 mr-2">Disc 1</label>
                                    <input pattern="[0-9,.]*" inputmode="decimal" id="disc_1{{ $id_item }}"
                                        type="text" name="sets[{{ $id_hpp_final }},{{ $id_item }}][disc_1]"
                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                        value="{{ $setId->disc_1 }}"
                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                </div>
                                <div class="flex items-center mb-4 mr-4">
                                    <label for="disc_2" class="w-32 mr-2">Disc 2</label>
                                    <input pattern="[0-9,.]*" inputmode="decimal" id="disc_2{{ $id_item }}"
                                        type="text" name="sets[{{ $id_hpp_final }},{{ $id_item }}][disc_2]"
                                        oninput="labapersen({{ $id_hpp_final }},{{ $id_item }})"
                                        value="{{ $setId->disc_2 }}"
                                        onkeyup="return checkInput(event,'0123456789.',this)"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
                                </div>
                                <div class="flex items-center mb-4">
                                    <label for="harga-jual" class="w-32 mr-2">Harga Jual</label>
                                    <input pattern="[0-9,.]*" inputmode="decimal" id="harga-jual{{ $id_item }}"
                                        type="text" readonly value="{{ number_format($setId->harga_jual,0,',','.') }}"
                                        name="sets[{{ $id_hpp_final }},{{ $id_item }}][harga_jual]"
                                        class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md number focus:border-blue-500 focus:outline-none">
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
            </div>
        @endforeach
    @endif
</div>
