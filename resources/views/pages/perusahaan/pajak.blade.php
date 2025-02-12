@php
    use App\Models\Pajak;
@endphp

@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h4 class="mr-auto text-lg font-medium text-primary">
            Data Pajak
        </h4>
    </div>
    @include('components.alert')
    <form action="{{ route('update.pajak') }}" method="POST">
        @csrf
        <div class="gap-5 sm:flex">
            <div class="w-full mt-5 intro-y box">
                <div
                    class="flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">
                        PPN
                    </h2>
                </div>
                <div id="vertical-form" class="p-5">
                    <div class="preview">
                        <label for="vertical-form-1" class="form-label">PPN</label>
                        <div class="flex gap-2">
                            <input value="{{ $ppn != null ? $ppn->ppn : '' }}" id="vertical-form-1" name="ppn"
                                type="text" class="form-control" placeholder="%">
                            <p class="mt-2">%</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full mt-5 intro-y box">
                <div
                    class="flex flex-col items-center p-5 border-b sm:flex-row border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">
                        No. Seri Pajak
                    </h2>
                </div>
                <div id="inline-form" class="p-5">
                    <div class="preview">
                        <label class="form-label">Nomor Seri Pajak</label>
                        <div class="gap-3 sm:flex">
                            <div class="flex">
                                <input name="no_seri_pajak" type="text" class="form-control" style="width: 80%;"
                                    id="formattedInput" placeholder="000.14.12345678">
                                <p class="mx-3 mt-2">s.d</p>
                                <input name="kali" id="horizontal-form-2" type="text" class="form-control"
                                    style="width: 20%;" placeholder="">
                            </div>
                            <div class="flex mt-4 sm:mt-0">
                                <label class="w-40 mt-2 form-label ">Tgl Expired</label>
                                <input name="tanggal_exp" id="horizontal-form-2" type="date" class="form-control"
                                    style="width: 100%;" placeholder="" value="{{ now()->toDateString() }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @can('akses_pajak_perusahaan')
            <button class="mt-5 btn btn-primary"> <i data-feather="save" class="w-4 h-4 mr-1"></i>
                Simpan </button>
        @endcan
    </form>
    <div class="col-span-12 mt-5 overflow-auto intro-y lg:overflow-visible">
        <table class="table -mt-2 table-report">
            <thead style="background-color: #d3d3d3;">
                <tr>
                    <th class="whitespace-nowrap">No</th>
                    <th class="whitespace-nowrap">No. Seri Pajak</th>
                    <th class="whitespace-nowrap">Tanggal ED</th>
                    <th class="whitespace-nowrap">Status</th>
                    <th class="text-center whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if (!Pajak::where('id_perusahaan', Auth::user()->id_perusahaan)->get()->isNotEmpty())
                    <tr class="intro-x">
                        <td colspan="5" class="font-bold text-center text-pending">Data belum tersedia</td>
                    </tr>
                @endif
                @foreach (Pajak::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $pajak)
                    <tr class="intro-x">
                        <td class="w-40">{{ $loop->iteration }}</td>
                        <td class="">{{ $pajak->pajak }}</td>
                        <td class="">{{ \Carbon\Carbon::parse($pajak->tanggal_exp)->format('j-m-Y') }}</td>
                        <td class="">{{ $pajak->status_digunakan == 1 ? 'Digunakan' : 'Belum digunakan' }}</td>
                        <td class="w-56 table-report__action">
                            <div class="flex items-center justify-center">
                                {{-- <a class="flex items-center mr-3" href="javascript:;"> <i data-feather="check-square"
                                class="w-4 h-4 mr-1"></i> Edit </a> --}}
                                @can('delete pajak')
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal"
                                        data-tw-target="#delete-confirmation-modal{{ $pajak->id }}"> <i
                                            data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                @endcan
                                <!-- BEGIN: Delete Confirmation Modal -->
                                @include('components.modal-delete', [
                                    'id_modal' => 'delete-confirmation-modal',
                                    'id' => $pajak->id,
                                    'route' => 'delete.pajak',
                                ])
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        const inputElement = document.getElementById('formattedInput');

        function formatNumber() {
            let value = inputElement.value.replace(/\D/g, '');
            if (value.length > 13) {
                value = value.slice(0, 13);
            }

            value = value.replace(/^(\d{3})(\d{2})/, "$1.$2.");

            inputElement.value = value;
        }
        inputElement.addEventListener('input', formatNumber);
    </script>
@endsection
