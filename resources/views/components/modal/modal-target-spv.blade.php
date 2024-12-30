 <!-- BEGIN: Modal Content -->
 <div id="{{ $id_modal . $id }}" class="modal" tabindex="-1" aria-hidden="true">
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="p-10 modal-body">
                 <div class="preview">
                     <a href="/target-spv-download-pdf/{{ $id }}"
                         class="flex items-center btn btn-facebook btn-sm "
                         style="position: absolute; right: 50px; top:10px;"><i data-feather="printer"
                             class="w-4 h-4 mr-1"></i>Print
                     </a>
                     <!-- <a href="/target-spv-download-excel/{{ $id }}" class="flex items-center btn btn-outline-primary btn-sm"
                         style="position: absolute; right: 120px; top:10px;"><i data-feather="file-text"
                             class="w-4 h-4 mr-1"
                             value="Export Excel"onclick="window.open('laporan-excel.php')"></i>Excel
                     </a> -->
                     <form action="{{ route($route, ['id' => $id]) }}" method="POST" onsubmit="return onSubmitForm()">
                         @csrf
                         <table>
                             <tr>
                                 <td>
                                     <label for="input-wizard-6"
                                         class="mt-2 mr-3 font-bold form-label">Supervisor</label>
                                 </td>
                                 <td class="w-full">
                                     <div class="flex col-span-12 mt-3 intro-y sm:col-span-6">
                                         <select id="input-wizard-6" class="form-select" required name="supervisor"
                                             {{ $lihat ? 'disabled' : '' }}>
                                             @foreach ($pegawais->where('jabatan', 'Supervisor') as $pegawai)
                                                 <option value="{{ $pegawai->id }}"
                                                     {{ $target ? ($target->supervisor == $pegawai->id ? 'selected' : '') : '' }}>
                                                     {{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan }}
                                                 </option>
                                             @endforeach
                                         </select>
                                     </div>
                                 </td>
                             </tr>

                             <tr>
                                 <td>
                                     <label for="input-wizard-6" class="mt-2 mr-3 font-bold form-label">Tahun</label>
                                 </td>
                                 <td class="w-full">
                                     <input required class="form-control" type="number" id="tahun" name="tahun"
                                         min="1900" max="2099" step="1" {{ $lihat ? 'readonly' : '' }}
                                         value="{{ $target ? $target->tahun : '' }}">
                                 </td>
                             </tr>
                         </table>
                         <table class="table mt-5 border border-slate-400">
                             <thead>
                                 <tr>
                                     <td>Bulan</td>
                                     <td>Target Penjualan</td>
                                     <td>Penjualan (A)</td>
                                     <td>Retur Penjualan (B)</td>
                                     <td>(A - B)</td>
                                     <td>% Target</td>
                                 </tr>
                             </thead>
                             <tbody>
                                 @php
                                     $months = [
                                         'Januari',
                                         'Februari',
                                         'Maret',
                                         'April',
                                         'Mei',
                                         'Juni',
                                         'Juli',
                                         'Agustus',
                                         'September',
                                         'Oktober',
                                         'November',
                                         'Desember',
                                     ];
                                 @endphp
                                 @foreach ($months as $key => $month)
                                     @php
                                         if ($target) {
                                             $penjualan = $penjualans
                                                 ->where('supervisor', $supervisor_id)
                                                 ->filter(function ($item) use ($key, $target) {
                                                     return $item->created_at->month === $key + 1 &&
                                                         $item->created_at->year == $target->tahun ?? '';
                                                 })
                                                 ->sum(function ($item) {
                                                     $cleanedTotal = str_replace('.', '', $item->total);
                                                     return (int) $cleanedTotal;
                                                 });

                                             $retur = $returPenjualan
                                                 ->where('supervisor', $supervisor_id)
                                                 ->filter(function ($item) use ($key, $target) {
                                                     return $item->created_at->month === $key + 1 &&
                                                         $item->created_at->year == $target->tahun ?? '';
                                                 })
                                                 ->sum('dpp');

                                             $thisTarget = $target
                                                 ? str_replace('.', '', $target->{'target_' . strtolower($month)})
                                                 : '';

                                             $hasil = $penjualan - $retur;
                                         }
                                     @endphp
                                     <tr>
                                         <td>{{ $month }}</td>
                                         <td>
                                             <input type="text" name="target_{{ strtolower($month) }}"
                                                 class="form-control target-input{{ $id_modal }}{{ $id }}"
                                                 value="{{ $target ? $target->{'target_' . strtolower($month)} : '' }}"
                                                 {{ $lihat ? 'readonly' : '' }}>
                                         </td>
                                         <td>
                                             {{ number_format($penjualan ?? 0, 0, ',', '.') }}
                                         </td>
                                         <td>
                                             {{ number_format($retur ?? 0, 0, ',', '.') }}
                                         </td>
                                         <td>
                                             {{ number_format($hasil ?? 0, 0, ',', '.') }}
                                         </td>
                                         <td>
                                             @if ($target)
                                                 @if ($thisTarget > 0)
                                                     {{ number_format(($hasil / $thisTarget) * 100, 2, ',', '.') }}%
                                                 @else
                                                     0%
                                                 @endif
                                             @endif
                                         </td>
                                     </tr>
                                 @endforeach

                                 <tr>
                                     <td class="font-bold">Total</td>
                                     <td class="total-target{{ $id_modal }}{{ $id }}"></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                     <td></td>
                                 </tr>
                             </tbody>
                         </table>

                         <script>
                             $(document).ready(function() {
                                 // Fungsi untuk format angka
                                 function numberFormat(value) {
                                     return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                 }

                                 // Fungsi untuk mengupdate total
                                 function updateTotal() {
                                     var total = 0;
                                     $('.target-input{{ $id_modal }}{{ $id }}').each(function() {
                                         var value = parseInt($(this).val().replace(/\D/g, ''), 10) || 0;
                                         total += value;
                                     });
                                     $('.total-target{{ $id_modal }}{{ $id }}').text(numberFormat(total));
                                 }

                                 // Event listener untuk input
                                 $('.target-input{{ $id_modal }}{{ $id }}').on('input', function() {
                                     var formattedValue = $(this).val().replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                     $(this).val(formattedValue);
                                     updateTotal();
                                 });

                                 // Panggil updateTotal saat pertama kali halaman dimuat untuk menghitung total awal
                                 updateTotal();
                             });
                         </script>
                         @if (!$lihat)
                             <div class="modal-footer">
                                 <button type="submit" id="submitBtn" class="mt-5 btn btn-primary"> Simpan </button>
                                 <button class="mt-5 btn btn-outline-danger" data-tw-dismiss="modal" type="button">
                                     Batal </button>
                             </div>
                         @endif
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <script>
         function onSubmitForm() {
             document.getElementById('submitBtn').disabled = true;
             document.getElementById('submitBtn').innerHTML = 'Mengirim...';
             return true;
         }
     </script>

 </div>
 <!-- END: Modal Content -->
