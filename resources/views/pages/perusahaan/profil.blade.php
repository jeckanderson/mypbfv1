@php
    use App\Models\Profile;
    use Laravolt\Indonesia\Models\Province;
    use Laravolt\Indonesia\Models\City;
@endphp

@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg font-medium text-primary">
            Profile Perusahaan
        </h2>
    </div>
    @if (session('success'))
        @include('components.alert')
    @endif

    <form action="{{ route('update.profile') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <!-- BEGIN: Profile Info -->
        <div class="px-5 pt-5 mt-5 intro-y box">
            <div class="flex flex-col pb-5 -mx-5 border-b lg:flex-row border-slate-200/60 dark:border-darkmode-400">
                <div class="flex items-center justify-center flex-1 px-5 lg:justify-start">
                    <div class="relative flex-none w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 image-fit">
                        <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" id="previewImage"
                            src="@if ($profile->logo_perusahaan) {{ url('storage/logo_perusahaan/' . $profile->logo_perusahaan) }}@else {{ url('dist/images/belum_tersedia.jpg') }} @endif">
                        <div
                            class="absolute bottom-0 right-0 flex items-center justify-center p-2 mb-1 mr-1 rounded-full bg-primary">
                            <label for="fileInput" class="cursor-pointer">
                                <i class="w-4 h-4 text-white" data-feather="camera"></i>
                                <input name="logo_perusahaan" type="file" id="fileInput" class="hidden" />
                                <input type="hidden" value="{{ $profile->logo_perusahaan }}" name="old_logo_perusahaan"
                                    id="oldLogoPerusahaan">
                            </label>
                        </div>
                    </div>

                    <div class="ml-5 w-full">
                        <div data-tw-merge class="items-center block mt-3 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Nama Perusahaan
                            </label>
                            <input name="nama_perusahaan" data-tw-merge id="horizontal-form-1" type="text"
                                value="{{ $profile->nama_perusahaan }}"
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-3 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                No. Ijin PBF
                            </label>
                            <input value="{{ $profile->no_ijin_pbf }}" name="no_ijin_pbf" data-tw-merge
                                id="horizontal-form-1" type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-3 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                No. Ijin DAK
                            </label>
                            <input value="{{ $profile->no_ijin_dak }}" name="no_ijin_dak" data-tw-merge
                                id="horizontal-form-1" type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block mt-3 sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                No. CDOB
                            </label>
                            <input value="{{ $profile->no_cdob }}" name="no_cdob" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                    </div>
                </div>
                <div
                    class="flex-1 px-5 pt-5 mt-6 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0">
                    <div class="mb-3 font-medium text-center lg:text-left lg:mt-3"></div>
                    <div data-tw-merge class="items-center block mt-3 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            Alamat Perusahaan
                        </label>
                        <input value="{{ $profile->alamat }}" name="alamat" data-tw-merge id="horizontal-form-1"
                            type="text" placeholder=""
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                    <div data-tw-merge class="items-center block mt-3 sm:flex">
                        <label data-tw-merge for="provinsi" class="inline-block mb-2 sm:w-60">
                            Provinsi
                        </label>
                        <select name="provinsi" id="provinsi" data-placeholder="Provinsi" class="w-full tom-select">
                            @foreach (Province::pluck('name', 'id') as $id => $name)
                                <option {{ $profile->provinsi == $id ? 'selected' : '' }} value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div data-tw-merge class="items-center block mt-3 sm:flex">
                        <label data-tw-merge for="kabupaten" class="inline-block mb-2 sm:w-60">
                            Kabupaten
                        </label>
                        <select name="kabupaten" id="kabupaten" data-placeholder="Kabupaten/Kota" class="w-full tom-select">
                            @foreach (City::pluck('name', 'id') as $id => $name)
                                <option {{ $profile->kabupaten == $id ? 'selected' : '' }} value="{{ $id }}">
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div data-tw-merge class="items-center block mt-3 sm:flex">
                        <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                            No. Telepon
                        </label>
                        <input value="{{ $profile->no_telepon }}" name="no_telepon" data-tw-merge id="horizontal-form-1"
                            type="text" placeholder=""
                            class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Profile Info -->
        <div class="mt-1">
            <div class="grid grid-cols-12 gap-6">
                <!-- BEGIN: New Products -->
                <div class="col-span-12 intro-y mt-2 box">
                    <div class="flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="mr-auto font-medium text-lg">
                            Detail Perusahaan
                        </h2>
                    </div>
                    <div class="grid gap-3 p-5 lg:items-start">
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                NPWP
                            </label>
                            <input value="{{ $profile->npwp }}" name="npwp" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Apoteker
                            </label>
                            <input value="{{ $profile->apoteker }}" name="apoteker" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                SIPA
                            </label>
                            <input value="{{ $profile->sipa }}" name="sipa" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                PJ Alkes
                            </label>
                            <input value="{{ $profile->pj_alkes }}" name="pj_alkes" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                SIP
                            </label>
                            <input value="{{ $profile->sip }}" name="sip" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Tgl. PKP
                            </label>
                            <input value="{{ $profile->tgl_pkp }}" name="tgl_pkp" value="tgl_pkp" id="regular-form-1"
                                type="text" class="form-control datepicker" data-single-mode="true">
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                No. PKP
                            </label>
                            <input name="no_pkp" value="{{ $profile->no_pkp }}" data-tw-merge id="horizontal-form-1"
                                type="text" placeholder=""
                                class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;[readonly]]:bg-slate-100 [&amp;[readonly]]:cursor-not-allowed [&amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80" />
                        </div>
                        <div data-tw-merge class="items-center block sm:flex">
                            <label data-tw-merge for="horizontal-form-1" class="inline-block mb-2 sm:w-60">
                                Tgl. Neraca Awal
                            </label>
                            <input value="{{ $profile->tgl_neraca_awal }}" name="tgl_neraca_awal" id="regular-form-1"
                                type="text" class="form-control datepicker" data-single-mode="true">
                        </div>
                    </div>
                </div>
                <!-- END: New Products -->
                <!-- BEGIN: New Authors -->
                <div class="col-span-12 intro-y box">
                    <div class="flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="mr-auto text-base font-medium text-lg">
                            Logo
                        </h2>
                    </div>
                    <div class="px-5 pt-5 mt-5 intro-y box">
                        <div
                            class="flex flex-col pb-5 -mx-5 border-b lg:flex-row border-slate-200/60 dark:border-darkmode-400">
                            <div
                                class="grid justify-center flex-1 px-5 pt-5 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0">
                                <div class="font-medium text-center">TTD APT</div>
                                <div class="relative flex-none w-20 h-20 mt-5 sm:w-24 sm:h-24 lg:w-32 lg:h-32">
                                    <img alt="Rubick Tailwind HTML Admin Template" class="w-full" id="previewImageTtdApt"
                                        src="@if ($profile->ttd_apt) {{ url('storage/ttd_apt/' . $profile->ttd_apt) }}@else {{ url('dist/images/belum_tersedia.jpg') }} @endif">
                                    <div
                                        class="absolute bottom-0 right-0 flex items-center justify-center p-2 mb-1 mr-1 rounded-full bg-primary">
                                        <label for="fileInputTtdApt" class="cursor-pointer">
                                            <i class="w-4 h-4 text-white" data-feather="camera"></i>
                                            <input name="ttd_apt" type="file" id="fileInputTtdApt" class="hidden" />
                                            <input type="hidden" value="{{ $profile->ttd_apt }}" name="old_ttd_apt"
                                                id="oldTtdApt">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="grid justify-center flex-1 px-5 pt-5 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0">
                                <div class="font-medium text-center">TTD Pj Alkes</div>
                                <div class="relative flex-none w-20 h-20 mt-5 sm:w-24 sm:h-24 lg:w-32 lg:h-32">
                                    <img alt="Rubick Tailwind HTML Admin Template" class=""
                                        id="previewImageTtdPjAlkes"
                                        src="@if ($profile->ttd_pj_alkes) {{ url('storage/ttd_pj_alkes/' . $profile->ttd_pj_alkes) }}@else {{ url('dist/images/belum_tersedia.jpg') }} @endif">
                                    <div
                                        class="absolute bottom-0 right-0 flex items-center justify-center p-2 mb-1 mr-1 rounded-full bg-primary">
                                        <label for="fileInputTtdPjAlkes" class="cursor-pointer">
                                            <i class="w-4 h-4 text-white" data-feather="camera"></i>
                                            <input name="ttd_pj_alkes" type="file" id="fileInputTtdPjAlkes"
                                                class="hidden" />
                                            <input type="hidden" value="{{ $profile->ttd_pj_alkes }}"
                                                name="old_ttd_pj_alkes" id="oldTtdPjAlkes">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="grid justify-center flex-1 px-5 pt-5 border-t border-l border-r lg:mt-0 border-slate-200/60 dark:border-darkmode-400 lg:border-t-0 lg:pt-0">
                                <div class="font-medium text-center">Stempel</div>
                                <div class="relative flex-none w-20 h-20 mt-5 sm:w-24 sm:h-24 lg:w-32 lg:h-32">
                                    <img alt="Rubick Tailwind HTML Admin Template" class=""
                                        id="previewImageStempel"
                                        src="@if ($profile->stempel) {{ url('storage/stempel/' . $profile->stempel) }}@else {{ url('dist/images/belum_tersedia.jpg') }} @endif">
                                    <div
                                        class="absolute bottom-0 right-0 flex items-center justify-center p-2 mb-1 mr-1 rounded-full bg-primary">
                                        <label for="fileInputStempel" class="cursor-pointer">
                                            <i class="w-4 h-4 text-white" data-feather="camera"></i>
                                            <input name="stempel" type="file" id="fileInputStempel" class="hidden" />
                                            <input type="hidden" value="{{ $profile->stempel }}" name="old_stempel"
                                                id="oldStempel">
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END: New Authors -->
            </div>
            @can('akses_profil_perusahaan')
                <div class="flex justify-center mt-5 align-center">
                    <button class="btn btn-primary" type="submit"> <i data-feather="save" class="w-4 h-4 mr-1"></i>
                        Simpan </button>
                </div>
            @endcan
        </div>
    </form>
    <script>
        function setupImageUpload(inputId, previewId, oldInputId) {
            const fileInput = document.getElementById(inputId);
            const previewImage = document.getElementById(previewId);
            const oldInput = document.getElementById(oldInputId);

            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };

                if (file) {
                    reader.readAsDataURL(file);
                }

                // Update hidden input (if you want to track the uploaded file on the server)
                if (oldInput) {
                    oldInput.value = file ? file.name : '';
                }
            });
        }

        // Call the function for each image upload section
        setupImageUpload('fileInput', 'previewImage', 'oldLogoPerusahaan');
        setupImageUpload('fileInputTtdApt', 'previewImageTtdApt', 'oldTtdApt');
        setupImageUpload('fileInputTtdPjAlkes', 'previewImageTtdPjAlkes', 'oldTtdPjAlkes');
        setupImageUpload('fileInputStempel', 'previewImageStempel', 'oldStempel');
    </script>
@endsection
