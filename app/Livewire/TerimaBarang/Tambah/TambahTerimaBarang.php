<?php

namespace App\Livewire\TerimaBarang\Tambah;

use App\Models\AkunAkutansi;
use App\Models\DiskonKelompok;
use App\Models\Jurnal;
use App\Models\Kelompok;
use App\Models\Pembelian;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use App\Models\SetHarga;
use App\Models\TerimaBarang;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TambahTerimaBarang extends Component
{
    //data sender
    public $gudangs = [], $raks = [], $sub_rak = [], $pembelians = [], $selected, $produks = [], $id_pembelian, $id, $getPembelian;
    //send
    public $no_reff, $no_faktur, $tanggal, $keterangan;
    //handel pilih produk
    public $selectedProduk = [], $jumlah = 0, $id_produk = 0, $mengurang = [], $hasil = [], $produkPembelian = [];


    protected $listeners = [
        'sendToTable' => 'getPembelian',
        'insertProduk' => 'getProduk',
    ];

    #[On('refresh')]
    public function render()
    {
        return view('livewire.terima-barang.tambah.tambah-terima-barang', [
            'daftarPembelian' => Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereNotIn('id', TerimaBarang::pluck('id_pembelian')->toArray())
                ->get()
        ]);
    }

    //handle pilih produk
    public function selectProduk()
    {
        if (!empty(array_filter($this->mengurang))) {
            $produks = ProdukPembelian::whereIn('id_order', $this->selectedProduk)->get();
            $diterima = array_values(array_filter($this->mengurang, function ($value) {
                return $value !== "";
            }));
            foreach ($produks as $index => $produk) {
                if (isset($diterima[$index])) {
                    ProdukDiterima::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_produk' => $produk->order->produk->id,
                        'id_sp' => $produk->id_sp,
                        'id_pembelian' => $this->id_pembelian,
                        'id_order' => $produk->order->id,
                        'diterima' => $diterima[$index],
                    ]);
                }
            }
            $this->dispatch('sendToTable', id_pembelian: $this->id_pembelian);
            $this->mengurang = [];
            $this->selectedProduk = [];
        }
    }

    public function getPembelian($id_pembelian)
    {
        $this->id_pembelian = $id_pembelian;
        $this->produkPembelian =  ProdukPembelian::where('id_pembelian', $this->id_pembelian)->get();
    }


    public function updatedGetPembelian()
    {
        if ($this->getPembelian) {
            $this->id_pembelian = $this->getPembelian;
            $this->pembelians = Pembelian::find($this->getPembelian);
            $this->no_reff = $this->pembelians->no_reff;
            $this->no_faktur = $this->pembelians->no_faktur;
            return $this->dispatch('sendToTable', id_pembelian: $this->getPembelian);
        }
    }

    public function mount()
    {
        $this->produks = ProdukDiterima::where('id_pembelian', $this->id_pembelian)->get();
        $this->tanggal = now()->toDateString();

        if ($this->id) {
            $dataTerimaBarang = TerimaBarang::find($this->id);
            $this->id_pembelian = ProdukDiterima::where('id_terima_barang', $this->id)->first()->id_pembelian;
            $this->getPembelian = $this->id;
            $this->no_reff = $dataTerimaBarang->no_reff;
            $this->tanggal = $dataTerimaBarang->tanggal;
            $this->no_faktur = $dataTerimaBarang->no_faktur;
            $this->produkPembelian =  ProdukPembelian::where('id_pembelian', $this->id_pembelian)->get();
            $this->keterangan = $dataTerimaBarang->keterangan;
        }
    }

    public function getProduk($id_produk)
    {
        $produks = ProdukPembelian::whereIn('id_order', $id_produk)->get();
        foreach ($produks as $produk) {
            ProdukDiterima::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_produk' => $produk->order->produk->id,
                'id_sp' => $produk->id_sp,
                'id_pembelian' => $this->id_pembelian,
                'id_order' => $produk->order->id,
            ]);
        }
        $this->dispatch('sendToTable', id_pembelian: ProdukPembelian::where('id_order', $id_produk[0])->first()->id_pembelian);
    }

    public function simpanTerimaBarang()
    {

        if (ProdukPembelian::where('id_pembelian', $this->id_pembelian)->sum('qty_faktur') - ProdukDiterima::where('id_pembelian', $this->id_pembelian)->sum('diterima') != 0) {
            $this->js("alert('Stok masih tersedia di penjualan! lengkapi stok untuk dapat menyimpan')");
        } elseif ($this->id) {
            $data = TerimaBarang::find($this->id);
            $terimaBarang = $data->update([
                'no_reff' => $this->no_reff,
                'tanggal' => $this->tanggal,
                'no_faktur' => $this->no_faktur,
                'keterangan' => $this->keterangan ?? '-',
            ]);
            $isCreate = false;
            $this->dispatch('simpanProdukDiterima', id_terima: $data->id, id_pembelian: $data->id_pembelian, isCreate: $isCreate);
            return redirect('terima-barang');
        } else {
            if ($this->id_pembelian == '') {
                $this->js("alert('Data belum lengkap')");
                return;
            }
            $cek = TerimaBarang::where('id_pembelian', $this->id_pembelian)->where('no_reff', $this->no_reff)->where('id_sp', Pembelian::find($this->id_pembelian)->id_sp);
            if ($cek->count() > 0) {
                return redirect('terima-barang');
            }
            $terimaBarang = TerimaBarang::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_pembelian' => $this->id_pembelian,
                'id_sp' => Pembelian::find($this->id_pembelian)->id_sp,
                'no_reff' => $this->no_reff,
                'tanggal' => $this->tanggal,
                'no_faktur' => $this->no_faktur,
                'keterangan' => $this->keterangan ?? '-',
            ]);

            if ($terimaBarang) {
                $pembelian = Pembelian::find($this->id_pembelian);
                $bayar = str_replace('.', '', str_replace(',', '.', $pembelian->jumlah_bayar));
                $totals = $pembelian->total_tagihan - $bayar;
                if ($totals > 0) {
                    $dataHutang = [
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_pembelian' => $pembelian->id,
                        'sumber' => 'pembelian',
                        'detailable_type' => Pembelian::class,
                        'detailable_id' => $pembelian->id,
                        'id_suplier' => $pembelian->suplier,
                        'nominal_bayar' => $bayar ?? 0,
                        'total_hutang' => $totals,
                        'sisa_hutang' => $totals
                    ];
                    if ($pembelian->jumlah_bayar > 0) {
                        $dataHutang += ['akun_akutansi_id' => $pembelian->akun->id];
                    }
                    $pembelian->hutang_pengguna()->create($dataHutang);
                }

                //memasukan ke jurnal
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => '1-3001',
                    'id_sumber' =>  $terimaBarang->id,
                    'sumber' => "Pembelian",
                    'keterangan' => 'Pembelian',
                    'debet' => $pembelian->ppn,
                ]);

                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => '1-2001',
                    'id_sumber' =>  $terimaBarang->id,
                    'sumber' => "Pembelian",
                    'keterangan' => 'Pembelian',
                    'debet' => $pembelian->dpp,
                ]);

                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => '2-1001',
                    'id_sumber' =>  $terimaBarang->id,
                    'sumber' => "Pembelian",
                    'keterangan' => 'Pembelian',
                    'kredit' => $pembelian->total_tagihan - str_replace('.', '', $pembelian->jumlah_bayar),
                ]);

                if ($pembelian->jumlah != 0) {
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $this->no_reff,
                        'kode_akun' => $pembelian->akun_bayar,
                        'id_sumber' =>  $terimaBarang->id,
                        'sumber' => "Pembelian",
                        'keterangan' => 'Pembelian',
                        'kredit' =>   str_replace('.', '', $pembelian->jumlah_bayar),
                    ]);
                }

                if ($pembelian->akun_biaya1) {
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $this->no_reff,
                        'kode_akun' => $pembelian->akun_biaya1,
                        'id_sumber' =>  $terimaBarang->id,
                        'sumber' => "Pembelian",
                        'keterangan' => 'Pembelian',
                        'debet' => str_replace('.', '', $pembelian->biaya1),
                    ]);
                }

                if ($pembelian->akun_biaya2) {
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $this->no_reff,
                        'kode_akun' => $pembelian->akun_biaya2,
                        'id_sumber' =>  $terimaBarang->id,
                        'sumber' => "Pembelian",
                        'keterangan' => 'Pembelian',
                        'debet' => str_replace('.', '', $pembelian->biaya2),
                    ]);
                }
                if ($pembelian->akun_bayar) {
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $this->no_reff,
                        'kode_akun' => $pembelian->akun_bayar,
                        'id_sumber' =>  $terimaBarang->id,
                        'sumber' => "Pembelian",
                        'keterangan' => 'Pembelian',
                        'kredit' => str_replace('.', '', $pembelian->jumlah_bayar),
                    ]);
                }

                $isCreate = true;
                $this->dispatch('simpanProdukDiterima', id_terima: $terimaBarang->id, id_pembelian: $this->id_pembelian, isCreate: $isCreate);
            }
        }
    }

    // public function getPembelian($id_pembelian)
    // {
    //     if ($id_pembelian) {
    //         $this->id_pembelian = $id_pembelian;
    //         $this->pembelians = Pembelian::find($id_pembelian);
    //         $this->no_reff = $this->pembelians->no_reff;
    //         $this->no_faktur = $this->pembelians->no_faktur;
    //     }
    // }
}