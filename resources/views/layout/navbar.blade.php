    <!-- BEGIN: Top Menu -->
    <nav class="top-nav">
        <ul class="">
            <li>
                @can('akses_dashboard_admin')
                    <a href="{{ url('/') }}" class="top-menu {{ $title == 'dashboard' ? 'top-menu--active' : '' }}">
                        <div class="top-menu__icon"> <i data-feather="home"></i> </div>
                        <div class="top-menu__title"> Dashboard
                            <!-- <i data-feather="chevron-down" class="top-menu__sub-icon"></i> -->
                        </div>
                    </a>
                    <!-- <ul class="top-menu__sub-open">
                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                <a href="/" class="top-menu">
                                                                                                                                                                                                                    <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                                                                                                                                                                                                    <div class="top-menu__title"> Dashboard Admin </div>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </li>
                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                <a href="/dashboad-marketing" class="top-menu">
                                                                                                                                                                                                                    <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                                                                                                                                                                                                    <div class="top-menu__title"> Dasboard Marketing </div>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </li>
                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                <a href="/dashboard-apoteker" class="top-menu">
                                                                                                                                                                                                                    <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                                                                                                                                                                                                    <div class="top-menu__title"> Dasboard Apoteker </div>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </li>
                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                <a href="/dashboard-keuangan" class="top-menu">
                                                                                                                                                                                                                    <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                                                                                                                                                                                                    <div class="top-menu__title"> Dasboard Keuangan </div>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </li>
                                                                                                                                                                                                            <li>
                                                                                                                                                                                                                <a href="/dashboard-gudang" class="top-menu">
                                                                                                                                                                                                                    <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                                                                                                                                                                                                    <div class="top-menu__title"> Dasboard Gudang </div>
                                                                                                                                                                                                                </a>
                                                                                                                                                                                                            </li>
                                                                                                                                                                                                        </ul> -->
                @endcan
            </li>
            <li>
                <a href="javascript:;" class="top-menu {{ $title == 'perusahaan' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="airplay"></i> </div>
                    <div class="top-menu__title"> Perusahaan <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    @can('akses_profil_perusahaan')
                        <li>
                            <a href="/profil-perusahaan" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title"> Profil Perusahaan </div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_pajak_perusahaan')
                        <li>
                            <a href="/pajak-perusahaan" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title"> Pajak Perusahaan </div>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Pegawai <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_jabatan')
                                <li>
                                    <a href="/jabatan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Jabatan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_nama_pegawai')
                                <li>
                                    <a href="/nama-pegawai" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Nama Pegawai</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_set_akses')
                                <li>
                                    <a href="/set-akses" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Set Akses</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_user')
                                <li>
                                    <a href="/set-user" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">User</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Marketing <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_area_rayon')
                                <li>
                                    <a href="/area-rayon" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Area Rayon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sub_rayon')
                                <li>
                                    <a href="/sub-rayon" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Sub Rayon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sales')
                                <li>
                                    <a href="/sales" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Sales</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_spv')
                                <li>
                                    <a href="/target-spv" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Target SPV</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_sales')
                                <li>
                                    <a href="/target-sales" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Target Sales</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_produk')
                                <li>
                                    <a href="/target-produk" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Target Produk</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="top-menu  {{ $title == 'master' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="file-plus"></i> </div>
                    <div class="top-menu__title"> Master <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Produk <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_produk')
                                <li>
                                    <a href="/obat-dan-barang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Produk</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_satuan')
                                <li>
                                    <a href="/satuan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Satuan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_kategori')
                                <li>
                                    <a href="/golongan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Kategori</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_golongan')
                                <li>
                                    <a href="/sub-golongan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Golongan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_jenis_produk')
                                <li>
                                    <a href="/jenis-obat-barang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Jenis Produk</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Gudang <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_nama_gudang')
                                <li>
                                    <a href="/nama-gudang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Nama Gudang</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_rak')
                                <li>
                                    <a href="/rak" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Rak</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sub_rak')
                                <li>
                                    <a href="/sub-rak" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Sub Rak</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Customer <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_kelompok')
                                <li>
                                    <a href="/kelompok" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Kelompok</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pelanggan')
                                <li>
                                    <a href="/pelanggan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Produsen & Supplier <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_produsen')
                                <li>
                                    <a href="/produsen" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Produsen</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_supplier')
                                <li>
                                    <a href="/suplier" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Supplier</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('akses_ekspedisi')
                        <li>
                            <a href="/ekspedisi" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Ekspedisi</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_akun_akuntansi')
                        <li>
                            <a href="/akun-akuntansi" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Akun Akutansi</div>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Barcode <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_barcode_produk')
                                <li>
                                    <a href="{{ route('barcode.produk') }}" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Produk</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_barcode_pelanggan')
                                <li>
                                    <a href="{{ route('barcode.pelanggan') }}" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="top-menu {{ $title == 'setting awal' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="settings"></i> </div>
                    <div class="top-menu__title"> Set Awal <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    @can('akses_hutang_awal')
                        <li>
                            <a href="/hutang-awal" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Hutang Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_piutang_awal')
                        <li>
                            <a href="/piutang-awal" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Piutang Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_stok_awal')
                        <li>
                            <a href="/stok-awal" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Stok Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_saldo_awal')
                        <li>
                            <a href="/saldo-awal" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Saldo Awal</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="top-menu  {{ $title == 'persediaan' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="package"></i> </div>
                    <div class="top-menu__title"> Persediaan <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i> </div>
                </a>
                <ul class="">
                    @can('akses_histori_stok')
                        <li>
                            <a href="/histori-stok" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Histori Stok</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_stok_opname')
                        <li>
                            <a href="/stok-opname" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Stok Opname</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_mutasi_stok')
                        <li>
                            <a href="/mutasi-stok" class="top-menu">
                                <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="top-menu__title">Mutasi Stok</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="top-menu  {{ $title == 'transaksi' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="shopping-cart"></i> </div>
                    <div class="top-menu__title"> Transaksi <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Rencana Pengadaan <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_analisis_pareto_abc')
                                <li>
                                    <a href="/analisis-pareto-abc" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Analisis Pareto ABC</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_analisis_ven')
                                <li>
                                    <a href="/analisis-order" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Analisis VEN</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_defecta')
                                <li>
                                    <a href="/defecta" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Defecta</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pembuatan_sp')
                                <li>
                                    <a href="/pembuatan-sp" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pembuatan SP</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Pembelian <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_pembelian')
                                <li>
                                    <a href="/pembelian " class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pembelian</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_terima_barang')
                                <li>
                                    <a href="/terima-barang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Terima Barang</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pembelian')
                                <li>
                                    <a href="/retur-pembelian" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Retur Pembelian</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Penjualan <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_sp_penjualan')
                                <li>
                                    <a href="/sp-penjualan " class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">SP Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_cek_sp_penjualan')
                                <li>
                                    <a href="/cek-sp-penjualan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Cek SP Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_setting_no_faktur')
                                <li>
                                    <a href="/setting-nomor-faktur" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Setting Faktur</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_penjualan')
                                <li>
                                    <a href="/penjualan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_penjualan')
                                <li>
                                    <a href="/retur-penjualan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Retur Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_surat_jalan')
                                <li>
                                    <a href="/surat-jalan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Surat Jalan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;"
                    class="top-menu  {{ $title == 'keuangan & akuntansi' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="file-text"></i> </div>
                    <div class="top-menu__title"> Finance <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="right-side">
                    <li class="">
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Keuangan <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_kontra_bon')
                                <li>
                                    <a href="/kontrabon" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Kontrabon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_tagihan_pelanggan')
                                <li>
                                    <a href="/tagihan-pelanggan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Tagihan Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pembayaran_hutang')
                                <li>
                                    <a href="/pembayaran-hutang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pembayaran Hutang</div>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="/kartu-hutang" class="top-menu">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Kartu Hutang</div>
                                </a>
                            </li>
                            @can('akses_pembayaran_piutang')
                                <li>
                                    <a href="/pembayaran-piutang" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pembayaran Piutang</div>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="/kartu-piutang" class="top-menu">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Kartu Piutang</div>
                                </a>
                            </li>
                            @can('akses_mutasi_saldo')
                                <li>
                                    <a href="/mutasi-saldo" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Mutasi Saldo</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_jurnal_akun')
                                <li>
                                    <a href="/jurnal-akun" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Jurnal Akun</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Akuntansi <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_jurnal_akun')
                                <li>
                                    <a href="/jurnal-umum " class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Jurnal Umum</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_buku_besar')
                                <li>
                                    <a href="/buku-besar" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Buku Besar</div>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li>
                                <a href="/neraca-lajur" class="top-menu">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Neraca Lajur</div>
                                </a>
                            </li> --}}
                            @can('akses_neraca')
                                <li>
                                    <a href="/neraca" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Neraca</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_laba_rugi')
                                <li>
                                    <a href="/laba-rugi" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Laba/Rugi</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="top-menu  {{ $title == 'utilities' ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"> <i data-feather="paperclip"></i> </div>
                    <div class="top-menu__title"> Utilities <i data-feather="chevron-down"
                            class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="right-side">
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Pajak <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_pajak_masukan')
                                <li>
                                    <a href="/pajak-masukan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pajak Masukan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pajak_masukan')
                                <li>
                                    <a href="/retur-pajak-masukan" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Retur Pajak Masukan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pajak_keluaran')
                                <li>
                                    <a href="/pajak-keluaran" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Pajak Keluaran</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pajak_keluaran')
                                <li>
                                    <a href="/retur-pajak-keluaran" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title"> Retur Pajak Keluaran</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Laporan <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_laporan_produk')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title"> Produk <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="left-side">
                                        <li>
                                            <a href="/price-list-produk" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Price List Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/exp-produk" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Exp Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/nilai-persediaan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Nilai Persediaan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_penjualan')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title">Penjualan <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/rekap-penjualan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Rekap Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-pelanggan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Penjualan Per Pelanggan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-faktur" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Penjualan Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-penjualan-faktur" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Detail Penjualan Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/laba-penjualan-produk" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Laba Penjualan Per Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-produk" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Penjualan Per Produk</div>
                                            </a>
                                        </li>



                                        <li>
                                            <a href="/detail-laba-faktur" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Detail Laba Per Faktur</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/retur-penjualans" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Retur Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-penjualans" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">SP. Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-sp-penjualan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Detail SP. Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-vs-penjualan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">SP. Penjualan VS Penjualan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_pembelian')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title"> Pembelian <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/estimasi-sp-pembelian" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Estimasi SP. Pembelian</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-pembelian" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">SP. Pembelian</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-pembelian-vs-pembelian" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">SP. Pembelian Vs Pembelian</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/pembelian-per-faktur" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Pembelian Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/pembelian-per-produk" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Pembelian Per Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/pembelian-per-supplier" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Pembelian Per Supplier</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-pembelian-per-faktur" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Detail Pembelian Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-terima-barang" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Detail Terima Barang</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_hutang')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title"> Hutang <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        {{-- <li>
                                        <a href="/rekap-hutang" class="top-menu">
                                            <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="top-menu__title">Rekap Hutang</div>
                                        </a>
                                    </li> --}}

                                        <li>
                                            <a href="/laporan-pembayaran-hutang" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Pembayaran Hutang</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/hutang-jatuh-tempo" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Hutang Jatuh Tempo</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_piutang')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title">Piutang <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        {{-- <li>
                                        <a href="/rekap-piutang " class="top-menu">
                                            <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="top-menu__title">Rekap Piutang</div>
                                        </a>
                                    </li> --}}
                                        {{-- <li>
                                        <a href="/kartu-piutang" class="top-menu">
                                            <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="top-menu__title">Kartu Piutang</div>
                                        </a>
                                    </li> --}}
                                        <li>
                                            <a href="/laporan-pembayaran-piutang" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Pembayaran Piutang</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/piutang-jatuh-tempo" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Piutang Jatuh Tempo</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_keuangan')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title">Keuangan <i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/kas-bank " class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">Kas dan Bank</div>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endcan
                            @can('akses_pbf')
                                <li>
                                    <a href="javascript:;" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="top-menu__title">PBF<i data-feather="chevron-down"
                                                class="top-menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/report-pbf" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">E-Report PBF</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/was-distribusi" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">E-Was Distribusi</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/was-penerimaan" class="top-menu">
                                                <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="top-menu__title">E-Was Penerimaan</div>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endcan
                        </ul>

                    </li>
                    <li>
                        <a href="/password-manager" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title">Password Manager</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title"> Database <i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        @can('akses_reset')
                            <ul class="left-side">
                                <li>
                                    <button class="top-menu" data-tw-toggle="modal"
                                        data-tw-target="#overlapping-modal-preview">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Reset</div>
                                    </button>
                                    <!-- BEGIN: Modal Content -->
                                    <div data-tw-backdrop="" aria-hidden="true" tabindex="-1"
                                        id="overlapping-modal-preview"
                                        class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 top-0 [&:not(.show)]:duration-[0s,0.2s] [&:not(.show)]:delay-[0.2s,0s] [&:not(.show)]:invisible [&:not(.show)]:opacity-0 [&.show]:visible [&.show]:opacity-100 [&.show]:duration-[0s,0.4s]">
                                        <div data-tw-merge
                                            class="w-[90%] mx-auto bg-white relative rounded-md shadow-md transition-[margin-top,transform] duration-[0.4s,0.3s] -mt-16 group-[.show]:mt-16 group-[.modal-static]:scale-[1.05] dark:bg-darkmode-600 sm:w-[460px]    px-5 py-10">
                                            <div class="text-center">
                                                <div class="mb-5">
                                                    Click button bellow to show overlapping modal!
                                                </div>
                                                <!-- BEGIN: Overlapping Modal Toggle -->
                                                <a href="#"
                                                    onclick="return confirm('Sekali lagi apakah Yakin database akan di reset? Aksi ini tidak bisa di kembalikan') ? window.location.href = '/reset-database' : false;"
                                                    class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90 [&:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-danger border-danger text-white dark:border-danger">Yakin
                                                    database akan di reset?</a>
                                                <!-- END: Overlapping Modal Toggle -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Modal Content -->
                                </li>
                            @endcan
                            @can('akses_backup')
                                <li>
                                    <a href="{{ route('backup.create') }}" class="top-menu">
                                        <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="top-menu__title">Backup</div>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li>
                                <a href="/restore" class="top-menu">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Restore</div>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="top-menu__title">Information<i data-feather="chevron-down"
                                    class="top-menu__sub-icon"></i> </div>
                        </a>
                        <ul class="right-side">
                            <li>
                                <a href="https://wa.me/6285723848868?text=Hallo%20CS%2C%20saya%20ingin%20bertanya"
                                    class="top-menu" target="_blank">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Whatsapp. CS</div>
                                </a>
                            </li>

                            <li>
                                <a href="https://www.youtube.com/@mycelesta9288" class="top-menu" target="_blank">
                                    <div class="top-menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="top-menu__title">Tutorial</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>

            </li>
        </ul>
    </nav>
    <!-- END: Top Menu -->
