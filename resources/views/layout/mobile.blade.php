    <!-- BEGIN: Mobile Menu -->
    <div class="mobile-menu md:hidden">
        <div class="mobile-menu-bar">
            <a href="" class="flex mr-auto">
                <img alt="Rubick Tailwind HTML Admin Template" class="w-20" src="{{ asset('dist/pbflogo.png') }}">
            </a>
            <a href="javascript:;" id="mobile-menu-toggler"> <i data-feather="bar-chart-2"
                    class="w-8 h-8 text-white transform -rotate-90"></i> </a>
        </div>
        <ul class="border-t border-white/[0.08] py-5 hidden">
            <li>
                @can('akses_dashboard_admin')
                    <a href="{{ url('/') }}" class="menu {{ $title == 'dashboard' ? 'menu--active' : '' }}">
                        <div class="menu__icon"> <i data-feather="home"></i> </div>
                        <div class="menu__title"> Dashboard
                            <!-- <i data-feather="chevron-down" class="menu__sub-icon"></i> -->
                        </div>
                    </a>
                @endcan
            </li>
            <li>
                <a href="javascript:;" class="menu {{ $title == 'perusahaan' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="airplay"></i> </div>
                    <div class="menu__title"> Perusahaan <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    @can('akses_profil_perusahaan')
                        <li>
                            <a href="/profil-perusahaan" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title"> Profil Perusahaan </div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_pajak_perusahaan')
                        <li>
                            <a href="/pajak-perusahaan" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title"> Pajak Perusahaan </div>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Pegawai <i data-feather="chevron-down" class="menu__sub-icon"></i>
                            </div>
                        </a>
                        <ul class="">
                            @can('akses_jabatan')
                                <li>
                                    <a href="/jabatan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Jabatan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_nama_pegawai')
                                <li>
                                    <a href="/nama-pegawai" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Nama Pegawai</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_set_akses')
                                <li>
                                    <a href="/set-akses" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Set Akses</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_user')
                                <li>
                                    <a href="/set-user" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">User</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Marketing <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_area_rayon')
                                <li>
                                    <a href="/area-rayon" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Area Rayon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sub_rayon')
                                <li>
                                    <a href="/sub-rayon" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Sub Rayon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sales')
                                <li>
                                    <a href="/sales" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Sales</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_spv')
                                <li>
                                    <a href="/target-spv" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Target SPV</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_sales')
                                <li>
                                    <a href="/target-sales" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Target Sales</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_target_produk')
                                <li>
                                    <a href="/target-produk" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Target Produk</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu  {{ $title == 'master' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="file-plus"></i> </div>
                    <div class="menu__title"> Master <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Produk <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_produk')
                                <li>
                                    <a href="/obat-dan-barang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Produk</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_satuan')
                                <li>
                                    <a href="/satuan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Satuan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_kategori')
                                <li>
                                    <a href="/golongan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Kategori</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_golongan')
                                <li>
                                    <a href="/sub-golongan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Golongan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_jenis_produk')
                                <li>
                                    <a href="/jenis-obat-barang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Jenis Produk</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Gudang <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_nama_gudang')
                                <li>
                                    <a href="/nama-gudang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Nama Gudang</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_rak')
                                <li>
                                    <a href="/rak" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Rak</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_sub_rak')
                                <li>
                                    <a href="/sub-rak" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Sub Rak</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Customer <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_kelompok')
                                <li>
                                    <a href="/kelompok" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Kelompok</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pelanggan')
                                <li>
                                    <a href="/pelanggan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Produsen & Supplier <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_produsen')
                                <li>
                                    <a href="/produsen" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Produsen</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_supplier')
                                <li>
                                    <a href="/suplier" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Supplier</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('akses_ekspedisi')
                        <li>
                            <a href="/ekspedisi" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Ekspedisi</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_akun_akuntansi')
                        <li>
                            <a href="/akun-akuntansi" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Akun Akutansi</div>
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Barcode <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_barcode_produk')
                                <li>
                                    <a href="{{ route('barcode.produk') }}" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Produk</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_barcode_pelanggan')
                                <li>
                                    <a href="{{ route('barcode.pelanggan') }}" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu {{ $title == 'setting awal' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="settings"></i> </div>
                    <div class="menu__title"> Set Awal <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    @can('akses_hutang_awal')
                        <li>
                            <a href="/hutang-awal" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Hutang Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_piutang_awal')
                        <li>
                            <a href="/piutang-awal" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Piutang Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_stok_awal')
                        <li>
                            <a href="/stok-awal" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Stok Awal</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_saldo_awal')
                        <li>
                            <a href="/saldo-awal" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Saldo Awal</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu  {{ $title == 'persediaan' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="package"></i> </div>
                    <div class="menu__title"> Persediaan <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    @can('akses_histori_stok')
                        <li>
                            <a href="/histori-stok" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Histori Stok</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_stok_opname')
                        <li>
                            <a href="/stok-opname" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Stok Opname</div>
                            </a>
                        </li>
                    @endcan
                    @can('akses_mutasi_stok')
                        <li>
                            <a href="/mutasi-stok" class="menu">
                                <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                <div class="menu__title">Mutasi Stok</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu  {{ $title == 'transaksi' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="shopping-cart"></i> </div>
                    <div class="menu__title"> Transaksi <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Rencana Pengadaan <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_analisis_pareto_abc')
                                <li>
                                    <a href="/analisis-pareto-abc" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Analisis Pareto ABC</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_analisis_ven')
                                <li>
                                    <a href="/analisis-order" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Analisis VEN</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_defecta')
                                <li>
                                    <a href="/defecta" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Defecta</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pembuatan_sp')
                                <li>
                                    <a href="/pembuatan-sp" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pembuatan SP</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Pembelian <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_pembelian')
                                <li>
                                    <a href="/pembelian " class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pembelian</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_terima_barang')
                                <li>
                                    <a href="/terima-barang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Terima Barang</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pembelian')
                                <li>
                                    <a href="/retur-pembelian" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Retur Pembelian</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Penjualan <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="">
                            @can('akses_sp_penjualan')
                                <li>
                                    <a href="/sp-penjualan " class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">SP Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_cek_sp_penjualan')
                                <li>
                                    <a href="/cek-sp-penjualan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Cek SP Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_setting_no_faktur')
                                <li>
                                    <a href="/setting-nomor-faktur" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Setting Faktur</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_penjualan')
                                <li>
                                    <a href="/penjualan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_penjualan')
                                <li>
                                    <a href="/retur-penjualan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Retur Penjualan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_surat_jalan')
                                <li>
                                    <a href="/surat-jalan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Surat Jalan</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu  {{ $title == 'keuangan & akuntansi' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="file-text"></i> </div>
                    <div class="menu__title"> Finance <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="right-side">
                    <li class="">
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Keuangan <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_kontra_bon')
                                <li>
                                    <a href="/kontrabon" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Kontrabon</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_tagihan_pelanggan')
                                <li>
                                    <a href="/tagihan-pelanggan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Tagihan Pelanggan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pembayaran_hutang')
                                <li>
                                    <a href="/pembayaran-hutang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pembayaran Hutang</div>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="/kartu-hutang" class="menu">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Kartu Hutang</div>
                                </a>
                            </li>
                            @can('akses_pembayaran_piutang')
                                <li>
                                    <a href="/pembayaran-piutang" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pembayaran Piutang</div>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a href="/kartu-piutang" class="menu">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Kartu Piutang</div>
                                </a>
                            </li>
                            @can('akses_mutasi_saldo')
                                <li>
                                    <a href="/mutasi-saldo" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Mutasi Saldo</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_jurnal_akun')
                                <li>
                                    <a href="/jurnal-akun" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Jurnal Akun</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Akuntansi <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_jurnal_akun')
                                <li>
                                    <a href="/jurnal-umum " class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Jurnal Umum</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_buku_besar')
                                <li>
                                    <a href="/buku-besar" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Buku Besar</div>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li>
                                <a href="/neraca-lajur" class="menu">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Neraca Lajur</div>
                                </a>
                            </li> --}}
                            @can('akses_neraca')
                                <li>
                                    <a href="/neraca" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Neraca</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_laba_rugi')
                                <li>
                                    <a href="/laba-rugi" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Laba/Rugi</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="menu  {{ $title == 'utilities' ? 'menu--active' : '' }}">
                    <div class="menu__icon"> <i data-feather="paperclip"></i> </div>
                    <div class="menu__title"> Utilities <i data-feather="chevron-down" class="menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="right-side">
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Pajak <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_pajak_masukan')
                                <li>
                                    <a href="/pajak-masukan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pajak Masukan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pajak_masukan')
                                <li>
                                    <a href="/retur-pajak-masukan" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Retur Pajak Masukan</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_pajak_keluaran')
                                <li>
                                    <a href="/pajak-keluaran" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Pajak Keluaran</div>
                                    </a>
                                </li>
                            @endcan
                            @can('akses_retur_pajak_keluaran')
                                <li>
                                    <a href="/retur-pajak-keluaran" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title"> Retur Pajak Keluaran</div>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Laporan <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="left-side">
                            @can('akses_laporan_produk')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title"> Produk <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="left-side">
                                        <li>
                                            <a href="/price-list-produk" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Price List Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/exp-produk" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Exp Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/nilai-persediaan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Nilai Persediaan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_penjualan')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title">Penjualan <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/rekap-penjualan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Rekap Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-pelanggan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Penjualan Per Pelanggan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-faktur" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Penjualan Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-penjualan-faktur" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Detail Penjualan Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/laba-penjualan-produk" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Laba Penjualan Per Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/penjualan-per-produk" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Penjualan Per Produk</div>
                                            </a>
                                        </li>



                                        <li>
                                            <a href="/detail-laba-faktur" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Detail Laba Per Faktur</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/retur-penjualans" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Retur Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-penjualans" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">SP. Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-sp-penjualan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Detail SP. Penjualan</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-vs-penjualan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">SP. Penjualan VS Penjualan</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_pembelian')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title"> Pembelian <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/estimasi-sp-pembelian" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Estimasi SP. Pembelian</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-pembelian" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">SP. Pembelian</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/sp-pembelian-vs-pembelian" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">SP. Pembelian Vs Pembelian</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/pembelian-per-faktur" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Pembelian Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/pembelian-per-produk" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Pembelian Per Produk</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/pembelian-per-supplier" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Pembelian Per Supplier</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-pembelian-per-faktur" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Detail Pembelian Per Faktur</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/detail-terima-barang" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Detail Terima Barang</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_hutang')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title"> Hutang <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        {{-- <li>
                                        <a href="/rekap-hutang" class="menu">
                                            <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="menu__title">Rekap Hutang</div>
                                        </a>
                                    </li> --}}

                                        <li>
                                            <a href="/laporan-pembayaran-hutang" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Pembayaran Hutang</div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="/hutang-jatuh-tempo" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Hutang Jatuh Tempo</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_laporan_piutang')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title">Piutang <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        {{-- <li>
                                        <a href="/rekap-piutang " class="menu">
                                            <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="menu__title">Rekap Piutang</div>
                                        </a>
                                    </li> --}}
                                        {{-- <li>
                                        <a href="/kartu-piutang" class="menu">
                                            <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                            <div class="menu__title">Kartu Piutang</div>
                                        </a>
                                    </li> --}}
                                        <li>
                                            <a href="/laporan-pembayaran-piutang" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Pembayaran Piutang</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/piutang-jatuh-tempo" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Piutang Jatuh Tempo</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan
                            @can('akses_keuangan')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title">Keuangan <i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/kas-bank " class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">Kas dan Bank</div>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endcan
                            @can('akses_pbf')
                                <li>
                                    <a href="javascript:;" class="menu">
                                        <div class="menu__icon"> <i data-feather="minus"></i> </div>
                                        <div class="menu__title">PBF<i data-feather="chevron-down"
                                                class="menu__sub-icon"></i> </div>
                                    </a>
                                    <ul class="right-side">
                                        <li>
                                            <a href="/report-pbf" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">E-Report PBF</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/was-distribusi" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">E-Was Distribusi</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/was-penerimaan" class="menu">
                                                <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                                <div class="menu__title">E-Was Penerimaan</div>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endcan
                        </ul>

                    </li>
                    <li>
                        <a href="/password-manager" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title">Password Manager</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title"> Database <i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        @can('akses_reset')
                            <ul class="left-side">
                                <li>
                                    <button class="menu" data-tw-toggle="modal"
                                        data-tw-target="#overlapping-modal-preview">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Reset</div>
                                    </button>
                                    <!-- BEGIN: Modal Content -->
                                    <div data-tw-backdrop="" aria-hidden="true" tabindex="-1"
                                        id="overlapping-modal-preview"
                                        class="modal group bg-black/60 transition-[visibility,opacity] w-screen h-screen fixed left-0 0 [&:not(.show)]:duration-[0s,0.2s] [&:not(.show)]:delay-[0.2s,0s] [&:not(.show)]:invisible [&:not(.show)]:opacity-0 [&.show]:visible [&.show]:opacity-100 [&.show]:duration-[0s,0.4s]">
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
                                    <a href="{{ route('backup.create') }}" class="menu">
                                        <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                        <div class="menu__title">Backup</div>
                                    </a>
                                </li>
                            @endcan
                            {{-- <li>
                                <a href="/restore" class="menu">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Restore</div>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"> <i data-feather="minus"></i> </div>
                            <div class="menu__title">Information<i data-feather="chevron-down"
                                    class="menu__sub-icon"></i> </div>
                        </a>
                        <ul class="right-side">
                            <li>
                                <a href="https://wa.me/6285723848868?text=Hallo%20CS%2C%20saya%20ingin%20bertanya"
                                    class="menu" target="_blank">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Whatsapp. CS</div>
                                </a>
                            </li>

                            <li>
                                <a href="https://www.youtube.com/@mycelesta9288" class="menu" target="_blank">
                                    <div class="menu__icon"> <i data-feather="more-horizontal"></i> </div>
                                    <div class="menu__title">Tutorial</div>
                                </a>
                            </li>

                        </ul>
                    </li>

                </ul>

            </li>
        </ul>
    </div>
    <!-- END: Mobile Menu -->
