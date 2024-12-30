<div>
    @php
        use App\Models\Jurnal;
        use App\Models\Profile;
        $profile = Profile::where('id', Auth::user()->id_perusahaan)->first();
        $tgl = date('Y-m-d', strtotime($profile->tgl_neraca_awal));
    @endphp

    <div class="p-5 mt-5 box">
        <div class="flex gap-2 overflow-auto mt-3">
            <label for="horizontal-form-1" class="font-bold inline-block text-lg mt-2 mb-2 sm:w-20">
                Periode
            </label>
            <?php
            // Mengambil bulan dan tahun saat ini
            $currentMonthYear = date('Y-m');
            ?>

            <div class="flex items-center gap-2">
                <input id="tanggal-bulan-tahun" name="tanggalBulanTahun" wire:model.live="tanggalBulanTahun" type="month"
                    value="<?php echo $currentMonthYear; ?>"
                    class="w-40 text-sm transition duration-200 ease-in-out rounded-sm shadow-sm disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 border-slate-200 focus:ring-4 focus:ring-primary focus:border-primary dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700" />
                <a href="{{ route('neraca.print', $tanggalBulanTahun) }}" class="flex items-center btn btn-facebook"
                    >
                    <i data-feather="printer" class="w-4 h-4 mr-1"></i> Print
                </a>
            </div>

        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk mendapatkan tanggal dalam format dd-mm-yyyy
                function formatTanggalIndonesia(date) {
                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();
                    return `${day}-${month}-${year}`;
                }

                // Dapatkan tanggal hari ini
                const today = new Date();

                // Tentukan tanggal mulai sebagai tanggal 1 bulan ini
                const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

                // Tentukan tanggal akhir sebagai akhir bulan ini
                const endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

                // Initialize Flatpickr dengan format Indonesia (dd-mm-yyyy)
                flatpickr("#tanggalMulai", {
                    defaultDate: formatTanggalIndonesia(startOfMonth),
                    dateFormat: "d-m-Y", // format Indonesia
                });

                flatpickr("#tanggalAkhir", {
                    defaultDate: formatTanggalIndonesia(endOfMonth),
                    dateFormat: "d-m-Y", // format Indonesia
                });
            });
        </script>

        <br>
        <hr>

        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="text-left p-3 text-lg font-bold text-primary">AKTIVA</th>
                    <th class="text-left p-3 text-lg font-bold text-primary">PASIVA</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- AKTIVA Section -->
                    <td class="align-top p-3">
                        <table class="w-full text-md">
                            @foreach ($dataActiva as $akun)
                                <tr class="mt-3">
                                    <td>{{ $akun['kode'] }}</td>
                                    <td>{{ $akun['nama_akun'] }}</td>
                                    <td class="text-right">
                                        {{ number_format(round($akun['total']), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="px-3 font-bold text-right">Total</td>
                                <td class="px-3 font-bold text-right text-white bg-primary">
                                    {{ number_format(round($totalSaldoAkunAktiva), 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>

                    <!-- PASIVA Section -->
                    <td class="align-top p-3">
                        <table class="w-full text-md">
                            @foreach ($dataPasiva as $akun)
                                <tr class="mt-3">
                                    <td>{{ $akun['kode'] }}</td>
                                    <td>{{ $akun['nama_akun'] }}</td>
                                    <td class="text-right">
                                        {{ number_format(round($akun['total']), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="px-3 font-bold text-right">Total</td>
                                <td class="px-3 font-bold text-right text-white bg-primary">
                                    {{ number_format(round($totalSaldoAkunKewajiban), 0, ',', '.') }}
                                </td>
                            </tr>
                            @foreach ($dataModal as $akun)
                                <tr class="mt-3">
                                    <td>{{ $akun['kode'] }}</td>
                                    <td>{{ $akun['nama_akun'] }}</td>
                                    <td class="text-right">
                                        {{ number_format(round($akun['total']), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="2" class="px-3 font-bold text-right">Total</td>
                                <td class="px-3 font-bold text-right text-white bg-primary">
                                    {{ number_format(round($totalSaldoAkunModal + $labaRugi), 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="p-3 text-right font-bold text-md text-white bg-pending">TOTAL AKTIVA :
                        {{ number_format(round($totalSaldoAkunAktiva), 0, ',', '.') }}
                    </td>
                    <td class="p-3 text-right font-bold text-md text-white bg-pending">TOTAL PASIVA :
                        {{ number_format(round($totalSaldoAkunModal + $totalSaldoAkunKewajiban + $labaRugi), 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
