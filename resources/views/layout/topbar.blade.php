@php
    use App\Models\Profile;
@endphp
<!-- BEGIN: Top Bar -->
<div class="border-b border-white/[0.08] -mt-5 md:-mt-5 -mx-3 sm:-mx-5 px-3 sm:px-5 pt-3 md:pt-0 mb-3">
    <div class="flex items-center mt-2 top-bar-boxed">
        <!-- BEGIN: Logo -->
        <a href="" class="hidden -intro-x md:flex">
            <img alt="Rubick Tailwind HTML Admin Template" class="w-20" src="{{ asset('dist/pbflogo.png') }}">
        </a>
        <!-- END: Logo -->
        <!-- BEGIN: Breadcrumb -->
        <nav aria-label="breadcrumb" class="h-full mr-auto -intro-x">
            <ol class="breadcrumb breadcrumb-light">
                <li class="breadcrumb-item"><a href="#">MYPBF</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::title($title) }}</li>
            </ol>
        </nav>
        <!-- END: Breadcrumb -->
        <!-- BEGIN: Header Buttons -->
        <div class="relative inline-block text-left">
            <button id="dropdownButton"
                class="btn btn-secondary btn-sm bg-white bg-green-500 hover:bg-green-700 text-black py-2 px-4 rounded flex items-center">
                <i data-feather="aperture" class="w-4 h-4 mr-2"></i>Shortcut Menu
            </button>

            <style>
                #dropdownMenu a:hover {
                    background-color: #1877F2;
                    /* Warna biru Facebook */
                    color: white;
                }
            </style>

            <div id="dropdownMenu"
                class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <a href="/obat-dan-barang" class="flex items-center px-4 py-2 text-sm text-gray-700"
                        role="menuitem">
                        <i data-feather="package" class="w-4 h-4 mr-2"></i>Produk
                    </a>
                    <a href="/pembuatan-sp" class="flex items-center px-4 py-2 text-sm text-gray-700" role="menuitem">
                        <i data-feather="file-plus" class="w-4 h-4 mr-2"></i>SP. Pembelian
                    </a>
                    <a href="/pembelian" class="flex items-center px-4 py-2 text-sm text-gray-700" role="menuitem">
                        <i data-feather="shopping-bag" class="w-4 h-4 mr-2"></i>Pembelian
                    </a>
                    <a href="/sp-penjualan" class="flex items-center px-4 py-2 text-sm text-gray-700" role="menuitem">
                        <i data-feather="edit-3" class="w-4 h-4 mr-2"></i>SP. Penjualan
                    </a>
                    <a href="/cek-sp-penjualan" class="flex items-center px-4 py-2 text-sm text-gray-700"
                        role="menuitem">
                        <i data-feather="clipboard" class="w-4 h-4 mr-2"></i>Cek SP. Penjualan
                    </a>
                    <a href="/penjualan" class="flex items-center px-4 py-2 text-sm text-gray-700" role="menuitem">
                        <i data-feather="shopping-cart" class="w-4 h-4 mr-2"></i>Penjualan
                    </a>
                </div>
            </div>

        </div>

        <script>
            const button = document.getElementById('dropdownButton');
            const menu = document.getElementById('dropdownMenu');

            button.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!button.contains(e.target) && !menu.contains(e.target)) {
                    menu.classList.add('hidden');
                }
            });

            feather.replace(); // to activate Feather icons
        </script>


        <!-- END: Header Buttons -->
        <!-- BEGIN: Account Menu -->
        <div class="w-8 h-8 ml-8 intro-x dropdown">
            <div class="w-8 h-8 overflow-hidden scale-110 rounded-full shadow-lg dropdown-toggle image-fit zoom-in"
                role="button" aria-expanded="false" data-tw-toggle="dropdown">
                <img alt="Profile"
                    src="@if (Profile::where('id_user', Auth::user()->id_perusahaan)->first()->logo_perusahaan) {{ url('storage/logo_perusahaan/' . Profile::where('id_user', Auth::user()->id_perusahaan)->first()->logo_perusahaan) }}@else {{ url('dist/images/belum_tersedia.jpg') }} @endif">
            </div>
            <div class="w-56 dropdown-menu">
                <ul class="dropdown-content bg-primary/80 text-white">
                    <li class="p-2">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">MYPBF Web</div>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <a href="/profil-perusahaan" class="dropdown-item hover:bg-white/5"> <i data-feather="user"
                                class="w-4 h-4 mr-2"></i> Profile </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider border-white/[0.08]">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item hover:bg-white/5"> <i
                                    data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END: Account Menu -->
    </div>
</div>
<!-- END: Top Bar -->
