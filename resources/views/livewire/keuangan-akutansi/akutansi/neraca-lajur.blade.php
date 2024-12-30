<div class="grid grid-cols-12 gap-6 mt-5">
    @php
        use App\Models\Jurnal;
    @endphp
    <div class="col-span-12 overflow-auto intro-y lg:overflow-visible">
        <div class="justify-between gap-3 sm:flex">
            <div class="">
                <div class="flex gap-2 mb-2 mr-auto overflow-auto sm:mb-0">
                    <label data-tw-merge for="horizontal-form-1" class="inline-block mt-2 mb-2 sm:w-20">
                        Tanggal
                    </label>
                    <input data-tw-merge id="horizontal-form-1" type="month" placeholder="Stok dari master"
                        class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                </div>
            </div>
            <div class="flex gap-2 mt-3 sm:mt-0">
                <button class="text-white btn btn-success">Tampilkan</button>
            </div>
        </div>
        <div class="mt-5 box">
            <div class="overflow-auto">
                <table class="table">
                    <thead class="font-bold text-center">
                        <tr>
                            <th class="border border-slate-600" rowspan="2">Kode</th>
                            <th class="border border-slate-600" rowspan="2">Nama Akun</th>
                            <th class="border border-slate-600" colspan="2">Neraca Saldo</th>
                            <th class="border border-slate-600" colspan="2">Jurnal Penyesuaian</th>
                            <th class="border border-slate-600" colspan="2">Setelan Penyesuaian</th>
                            <th class="border border-slate-600" colspan="2">Laba/Rugi</th>
                            <th class="border border-slate-600" colspan="2">Neraca</th>
                        </tr>
                        <tr>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                            <th class="border border-slate-600">Debet</th>
                            <th class="border border-slate-600">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($akuns as $akun)
                            @php
                                $jurnal = Jurnal::where('id_perusahaan', Auth::user()->id_perusahaan);
                            @endphp
                            <tr class="text-center">
                                <td class="border border-slate-600 whitespace-nowrap">{{ $akun->kode }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">{{ $akun->nama_akun }}</td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('debet')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('kredit')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td>
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('debet')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('kredit')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td>
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('debet')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">
                                    {{ number_format(round($jurnal->where('kode_akun', $akun->kode)->sum('kredit')), 0, ',', '.') ?: '-' }}
                                </td>
                                <td class="border border-slate-600 whitespace-nowrap">Contoh Data</td>
                                <td class="border border-slate-600 whitespace-nowrap">Contoh Data</td>
                                <td class="border border-slate-600 whitespace-nowrap">Contoh Data</td>
                                <td class="border border-slate-600 whitespace-nowrap">Contoh Data</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">Belum ada data tersedia</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="flex justify-center mt-4 mb-5 align-item-center ">
                    {{ $akuns->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
