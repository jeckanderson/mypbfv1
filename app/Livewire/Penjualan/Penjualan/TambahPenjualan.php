<?php

namespace App\Livewire\Penjualan\Penjualan;

use App\Models\AkunAkutansi;
use App\Models\DiskonKelompok;
use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\Pajak;
use App\Models\PasswordAkses;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PiutangPengguna;
use App\Models\PPN;
use App\Models\ProdukDiterima;
use App\Models\ProdukPenjualan;
use App\Models\SetHarga;
use App\Models\SetNoFaktur;
use App\Models\SPPenjualan;
use App\Models\StokAwal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\Calculation\Database\DVar;

class TambahPenjualan extends Component
{
    public $spTerpilih, $pelanggan, $sales, $id_kelompok, $getDiskon, $akuns, $akuns2, $disabled = 'disabled', $spPenjualan, $id_sp, $hppModal = [];
    //masuk form
    public $no_sp, $tgl_input, $tgl_faktur, $no_reff, $no_faktur, $id_pelanggan, $id_sales, $kredit, $tempo_kredit, $no_seri_pajak, $produks = [], $subtotal = 0, $penghitungan = [], $id_no_seri_pajak,
        $diskon = 0, $hasil_diskon = 0, $dpp, $ppn, $biaya1 = 0, $akun_biaya1, $biaya2 = 0, $akun_biaya2, $total_tagihan, $akun_bayar, $jumlah_bayar = 0, $kurang, $total_hutang = 0, $keterangan, $bonus = false;

    //unlock price
    public $readonly = 'readonly', $unlockDisplay = false, $priceModified = false, $locked = true, $password, $message;

    public function render()
    {
        return view('livewire.penjualan.penjualan.tambah-penjualan');
    }

    public function updatedKredit()
    {
        if ($this->id_pelanggan == '') {
            $this->js("alert('Pelanggan tidak ditemukan')");
            return;
        }
        $this->disabled = $this->kredit ? '' : 'disabled';
        $this->tempo_kredit = now()->addDays(Pelanggan::find($this->id_pelanggan)->batas_jt)->toDateString();
    }

    public function updatedIdSp()
    {
        $this->spTerpilih = $this->id_sp;
        $spPenjualan = SPPenjualan::find($this->spTerpilih);
        if ($spPenjualan) {
            $this->no_sp = $spPenjualan->no_sp;
            $this->tgl_input = $spPenjualan->tgl_input;
            $this->pelanggan = $spPenjualan->pelangganPenjualan->nama;
            $this->id_pelanggan = $spPenjualan->pelanggan;
            $this->id_kelompok = $spPenjualan->pelangganPenjualan->kelompokPelanggan->id;
            $this->sales = $spPenjualan->salesPenjualan->nama_pegawai;
            $this->id_sales = $spPenjualan->sales;
            $this->produks = $spPenjualan->produkPenjualan()->where('qty', '<>', 0)->get();
            foreach ($this->produks as $key => $prod) {
                $this->hitungHarga($key);
            }
            if ($spPenjualan->tipe_sp === 'SP. Bonus') {
                $this->bonus = true;
            }
        }
    }

    #[On('pilihPajak')]
    public function selectPajak($id_pajak)
    {
        $this->id_no_seri_pajak = $id_pajak;
        $this->no_seri_pajak = Pajak::find($id_pajak)->pajak;
    }

    public function mount()
    {
        $this->spPenjualan = SPPenjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->where('kirim_penjualan', 1)->whereNotIn('id', Penjualan::pluck('id_sp'))->get();
        $this->akuns = AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->akuns2 = AkunAkutansi::where('kode', 'LIKE', '%7-%')->get();
        $this->tgl_faktur = now()->toDateString();
        $urutan = str_pad(Penjualan::count() + 1, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/JL/' . date('m-y');
        $urutanFaktur = str_pad(Penjualan::count() + 1, 6, '0', STR_PAD_LEFT);
        if (SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first()) {
            $faktur = SetNoFaktur::where('id_perusahaan', Auth::user()->id_perusahaan)->first()->no_surat;
            $this->no_faktur = $urutanFaktur . '/' . $faktur . '/' . date('m-y');
        }
    }
    public function unlock()
    {
        $user = PasswordAkses::where('type', 'open-price')->first();
        if (Hash::check($this->password, $user->password)) {
            $this->priceModified = true;
            $this->readonly = false;
            $this->locked = false;
            $this->unlockDisplay = false;
            $this->message = '';
        } else {
            $this->message = 'Password yang anda masukan salah';
        }
    }

    public function cancelUnlock()
    {
        $this->unlockDisplay = false;
    }

    public function openLockDisplay()
    {
        $this->unlockDisplay = true;
    }

    public function hitungHarga($key)
    {
        $this->getDiskon = DiskonKelompok::where('id_obat_barang', $this->produks[$key]->produk->id)
            ->where('id_kelompok', $this->id_kelompok)
            ->where('satuan_dasar_beli', $this->produks[$key]->satuan)
            ->first();

        // if ($this->produks) {
        //     $this->js("alert('Maaf, produk tidak tersedia, cek ketersediaan stok produk terlebih dahulu')");
        //     return;
        // }

        $setHarga = SetHarga::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('id_set_harga', $this->produks[$key]->histori->id_set_harga)
            ->where('sumber', $this->produks[$key]->histori->sumber_set_harga)
            ->where('satuan', $this->produks[$key]->satuan)
            ->where('id_kelompok', Pelanggan::find($this->id_pelanggan)->kelompok);

        // $harga = str_replace('.', '', $setHarga->first()->hpp_final);
        $harga = str_replace('.', '', $setHarga->first()->hpp_final ?? '0');

        $harga = str_replace(',', '.', $harga);
        // Ambil data sesuai 'satuan'
        $item = $setHarga->where('satuan', $this->produks[$key]->satuan)->first();

        // Pastikan $item dan hpp_final valid
        $hppFinal = $item ? $item->hpp_final : 0;

        // Pastikan qty valid
        $qty = is_numeric($this->produks[$key]->qty) ? $this->produks[$key]->qty : 0;

        // Hitung modal
        $modal = is_numeric($hppFinal) ? $hppFinal * $qty : 0;

        // Simpan ke hppModal
        $this->hppModal[$key] = $modal;

        if ($setHarga->first()) {
            $this->penghitungan[$key]['harga'] = number_format(str_replace('.', '', $setHarga->where('satuan', $this->produks[$key]->satuan)->first()->hasil_laba), 0, ',', '.');
            $this->penghitungan[$key]['disc_1'] = $this->bonus == true ? 100 : $setHarga->where('satuan', $this->produks[$key]->satuan)->first()->disc_1;
            $this->penghitungan[$key]['disc_2'] =  $this->bonus == true ? 0 : $setHarga->where('satuan', $this->produks[$key]->satuan)->first()->disc_2;
            $this->penghitungan[$key]['total'] =   $this->bonus == true ? 0 : number_format(str_replace('.', '', $setHarga->where('satuan', $this->produks[$key]->satuan)->first()->harga_jual) * $this->produks[$key]->qty, 0, ',', '.');
            $this->penghitungan[$key]['modal_produk'] = str_replace('.', '', $setHarga->where('satuan', $this->produks[$key]->satuan)->first()->harga_jual) - ($this->hasil_diskon / $this->produks[$key]->qty);
            // $this->penghitungan[$key]['modal_produk'] = $harga;
            $this->penghitungan[$key]['total_modal'] = $this->penghitungan[$key]['modal_produk'] * $this->produks[$key]->qty;
            if (isset($this->penghitungan[$key]['total'])) {
                $this->subtotal = 0;
                foreach ($this->penghitungan as $get) {
                    $this->subtotal += str_replace('.', '', $get['total']);
                }
                $this->updateAngka();
                return str_replace('.', '.', $this->penghitungan[$key]['total']);
            } else {
                $this->updateAngka();
                return 0;
            }
        } else {
            $this->penghitungan[$key]['harga'] = 'Harga belum di set';
            $this->penghitungan[$key]['harga_qty'] = 'Harga belum di set';
            $this->penghitungan[$key]['disc_1'] = 'Harga belum di set';
            $this->penghitungan[$key]['disc_2'] = 'Harga belum di set';
            $this->penghitungan[$key]['total'] = 'Harga belum di set';
        }
    }
    //     } else {
    //     $this->penghitungan[$key]['harga'] = 0;
    //     $this->penghitungan[$key]['harga_qty'] = 0;
    //     $this->penghitungan[$key]['disc_1'] = 0;
    //     $this->penghitungan[$key]['disc_2'] = 0;
    //     $this->penghitungan[$key]['total'] = 0;
    // }
    public function hitung($key)
    {
        $this->priceModified = true;
        $harga = $this->penghitungan[$key]['harga'];
        $disc1 = $this->penghitungan[$key]['disc_1'];
        $disc2 = $this->penghitungan[$key]['disc_2'];
        $harga_qty = $this->produks[$key]->qty * str_replace('.', '', $harga);
        $total_awal = $harga_qty - ($harga_qty * $disc1 / 100);
        $this->penghitungan[$key]['total'] = number_format($total_awal - ($total_awal * $disc2 / 100), 0, ',', '.');
        if (isset($this->penghitungan[$key]['total'])) {
            $this->subtotal = 0;
            foreach ($this->penghitungan as $get) {
                $this->subtotal += str_replace('.', '', $get['total']);
            }
            $this->updateAngka();
            return str_replace('.', '.', $this->penghitungan[$key]['total']);
        } else {
            $this->updateAngka();
            return 0;
        }
    }

    public function updatedDiskon()
    {
        $this->hasil_diskon = round($this->subtotal * ((isset($this->diskon) && is_numeric($this->diskon) ? $this->diskon : 0) / 100));
        $this->updateAngka();
        $this->updatedBiaya1();
        $this->updatedBiaya2();
        $this->updatedJumlahBayar();
    }

    public function updateAngka()
    {
        $ppn = PPN::where('id', Auth::user()->id_perusahaan)->first()->ppn;
        $this->dpp = round($this->subtotal - $this->hasil_diskon);
        $this->ppn = round($this->dpp * ($ppn / 100));
        $this->updatedBiaya1();
        $this->updatedBiaya2();
        $this->updatedJumlahBayar();
    }

    public function updatedBiaya1()
    {
        $this->total_tagihan = $this->dpp + $this->ppn + floatval(str_replace('.', '', $this->biaya1)) + floatval(str_replace('.', '', $this->biaya2));
    }

    public function updatedBiaya2()
    {
        $this->updatedBiaya1();
        $this->updatedJumlahBayar();
    }

    public function updatedJumlahBayar()
    {
        $this->total_hutang = $this->total_tagihan - floatval(str_replace('.', '', $this->jumlah_bayar));
    }

    public function simpanPenjualan()
    {
        DB::beginTransaction();
        $produk = ProdukPenjualan::where('id_sp_penjualan', $this->spTerpilih)->where('qty', '!=', 0)->get();

        if ($this->kredit == 1 and $this->total_hutang == 0) {
            $this->js("alert('Pembayaran lunas tidak bisa di kredit')");
            return;
        }

        if ($this->locked == true && $this->priceModified == true) {
            $this->js("alert('Perubahan harga tidak sah, silahkan buka kunci dengan benar')");
            return;
        }
        if ($this->akun_bayar <> '' and $this->jumlah_bayar == 0) {
            $this->js("alert('Masukkan jumlah bayar')");
            return;
        }

        if ($produk->isEmpty()) {
            $this->js("alert('Tidak ada produk tersedia, penjualan tidak tersimpan')");
            return;
        }

        if (!$this->produks) {
            $this->js("alert('Tidak ada produk tersedia, penjualan tidak tersimpan')");
            return;
        }

        $urutan = str_pad(Penjualan::count() + 1, 6, '0', STR_PAD_LEFT);
        $no_reff = $urutan . '/JL/' . date('m-y');
        if ($this->total_hutang < 0) {
            $this->js("alert('Jumlah bayar yang anda masukan melebihi total bayar')");
        } else {
            $cekPenjualan = Penjualan::where('no_sp', $this->no_sp);
            if ($cekPenjualan->count() > 0) {
                $this->js("alert('Data penjualan dengan nomor sp ini sudah ada')");
                return;
            }
            $simpanPenjualan = Penjualan::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $no_reff,
                'no_sp' => $this->no_sp,
                'no_faktur' => $this->no_faktur,
                'id_sp' => $this->spTerpilih,
                'tgl_input' => $this->tgl_input,
                'tgl_faktur' => $this->tgl_faktur,
                'pelanggan' => $this->id_pelanggan,
                'sales' => $this->id_sales,
                'kredit' => $this->kredit ? 1 : 0,
                'tempo_kredit' => $this->kredit ? $this->tempo_kredit : '',
                'no_seri_pajak' => $this->no_seri_pajak,
                'subtotal' => $this->subtotal,
                'diskon' => $this->diskon,
                'hasil_diskon' => $this->hasil_diskon ?? 0,
                'dpp' => $this->dpp,
                'ppn' => $this->ppn,
                'biaya1' => $this->biaya1,
                'akun_biaya1' => $this->akun_biaya1 ?? '-',
                'biaya2' => $this->biaya2,
                'akun_biaya2' => $this->akun_biaya2 ?? '-',
                'total_tagihan' => $this->total_tagihan,
                'akun_bayar' => $this->akun_bayar ?? '-',
                'jumlah_bayar' => $this->jumlah_bayar,
                'total_hutang' => $this->total_hutang,
                'keterangan' => $this->keterangan,
            ]);
            if ($simpanPenjualan) {
                if ($this->id_no_seri_pajak) {
                    Pajak::find($this->id_no_seri_pajak)->update(['status_digunakan' => 1]);
                }
                foreach ($this->penghitungan as $key => $simpan) {
                    //ambil jumlah isi sesuai satuan
                    $isiSatuan = DiskonKelompok::where('id_obat_barang', $produk[$key]->id_produk)->where('satuan_dasar_beli', $produk[$key]->satuan)->first()->isi;
                    //masukan ke history stok

                    if (($produk[$key]->produk->getStockBatch($produk[$key]->id_produk, $produk[$key]->batch, $produk[$key]->gudang, $produk[$key]->rak, $produk[$key]->sub_rak)) < ($produk[$key]->qty * $isiSatuan)) {
                        $this->js('alert("Stock tidak mencukupi")');
                        DB::rollBack();
                        return;
                    }
                    $simpanHistory = HistoryStok::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_produk' =>  $produk[$key]->id_produk,
                        'no_reff' => $no_reff,
                        'no_faktur' => $this->no_faktur,
                        'no_batch' => $produk[$key]->batch,
                        'exp_date' => $produk[$key]->exp_date ?? '-',
                        'suplier_pelanggan' => $this->id_pelanggan,
                        'id_gudang' => $produk[$key]->gudang,
                        'id_rak' => $produk[$key]->rak,
                        'id_sub_rak' => $produk[$key]->sub_rak,
                        'sumber_set_harga' => $produk[$key]->historiCekSp->sumber_set_harga,
                        'id_set_harga' => $produk[$key]->id_sumber,
                        'stok_masuk' => 0,
                        'stok_keluar' => $produk[$key]->qty * $isiSatuan,
                        'stok_akhir' => ($produk[$key]->produk->stock->stok_akhir) - ($produk[$key]->qty * $isiSatuan),
                        // 'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $produk[$key]->id_obat_barang)->where('id_gudang', $produk[$key]->gudang)->where('id_rak', $produk[$key]->rak)->where('id_sub_rak', $produk[$key]->sub_rak)->latest()->first()->stok_akhir ?? 0) - $isiSatuan,
                        'keterangan' => 'Penjualan'
                    ]);

                    $produk[$key]->update([
                        'id_penjualan' => $simpanPenjualan->id,
                        'id_histori' => $simpanHistory->id,
                        'harga' => str_replace('.', '', $simpan['harga']),
                        'disc_1' => $simpan['disc_1'] ?? 0,
                        'disc_2' => $simpan['disc_2'] ?? 0,
                        'terpesan' => 0,
                        'total' => $simpan['total'],
                        'modal_produk' => $simpan['modal_produk'],
                        'total_modal' => $simpan['total_modal'],
                        'masuk_penjualan' => 1,
                    ]);
                }
                if ($this->total_hutang != 0) {
                    $dataPiutang = [
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_penjualan' => $simpanPenjualan->id,
                        'sumber' => 'penjualan',
                        'id_pelanggan' => $this->id_pelanggan,
                        'nominal_bayar' => $this->jumlah_bayar ?? 0,
                        'total_hutang' => $this->total_tagihan - $this->total_tagihan ?? 0,
                        'sisa_hutang' => $this->total_hutang,
                        'detailable_type' => Penjualan::class,
                        'detailable_id' => $simpanPenjualan->id
                    ];
                    if ($simpanPenjualan->jumlah_bayar > 0) {
                        $dataPiutang += ['akun_akutansi_id' => AkunAkutansi::where('kode', $simpanPenjualan->akun_bayar)->first()->id];
                    }
                    $simpanPenjualan->piutang_pengguna()->create($dataPiutang);
                }
                //persediaan dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(3)->kode,
                    'id_sumber' => $simpanPenjualan->id,
                    'sumber' => 'Penjualan',
                    'keterangan' => 'Penjualan',
                    'kredit' => round(array_sum($this->hppModal)),
                ]);

                //Hpp dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(34)->kode,
                    'id_sumber' => $simpanPenjualan->id,
                    'sumber' => 'Penjualan',
                    'keterangan' => 'Penjualan',
                    'debet' => round(array_sum($this->hppModal)),
                ]);

                //Pendapatan dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(32)->kode,
                    'id_sumber' => $simpanPenjualan->id,
                    'sumber' => 'Penjualan',
                    'keterangan' => 'Penjualan',
                    'kredit' => $this->dpp,
                ]);

                //PPN keluaran
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(24)->kode,
                    'id_sumber' => $simpanPenjualan->id,
                    'sumber' => 'Penjualan',
                    'keterangan' => 'Penjualan',
                    'kredit' => $this->ppn,
                ]);
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(1)->kode,
                    'id_sumber' => $simpanPenjualan->id,
                    'sumber' => 'Penjualan',
                    'keterangan' => 'Penjualan',
                    'debet' => $simpanPenjualan->total_tagihan - (str_replace('.', '', str_replace(',', '.', $this->jumlah_bayar)) ?? 0),
                ]);
                // if ($this->kurang) {
                //     //Piutang dagang dan konsi

                // }
                if ($this->akun_biaya1) {
                    //biaya 1
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                        'kode_akun' => AkunAkutansi::where('kode', $this->akun_biaya1)->first()->kode ??  $this->akun_biaya1,
                        'id_sumber' => $simpanPenjualan->id,
                        'sumber' => 'Penjualan',
                        'keterangan' => 'Penjualan',
                        'kredit' => str_replace('.', '', str_replace(',', '.', $this->biaya1)),
                    ]);
                }

                if ($this->akun_biaya2) {
                    //biaya 2
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                        'kode_akun' => AkunAkutansi::where('kode', $this->akun_biaya2)->first()->kode ??  $this->akun_biaya2,
                        'id_sumber' => $simpanPenjualan->id,
                        'sumber' => 'Penjualan',
                        'keterangan' => 'Penjualan',
                        'kredit' => str_replace('.', '', str_replace(',', '.', $this->biaya2)),
                    ]);
                }

                if ($this->akun_bayar) {
                    //kas bank
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' =>  $urutan . '/JL/' . date('m-y'),
                        'kode_akun' => $this->akun_bayar,
                        'id_sumber' => $simpanPenjualan->id,
                        'sumber' => 'Penjualan',
                        'keterangan' => 'Penjualan',
                        'debet' => str_replace('.', '', str_replace(',', '.', $this->jumlah_bayar)),
                    ]);
                }
                DB::commit();
                return redirect('/penjualan');
            }
        }
    }


    // #[On('getSP')]
    // public function getIdSP($id_sp)
    // {
    //     $this->spTerpilih = $id_sp;
    //     $spPenjualan = SPPenjualan::find($this->spTerpilih);
    //     if ($spPenjualan) {
    //         $this->no_sp = $spPenjualan->no_sp;
    //         $this->tgl_input = $spPenjualan->tgl_input;
    //         $this->pelanggan = $spPenjualan->pelangganPenjualan->nama;
    //         $this->id_pelanggan = $spPenjualan->pelanggan;
    //         $this->id_kelompok = $spPenjualan->pelangganPenjualan->kelompokPelanggan->id;
    //         $this->sales = $spPenjualan->salesPenjualan->nama_pegawai;
    //         $this->id_sales = $spPenjualan->sales;
    //         $this->produks = ProdukPenjualan::where('id_sp_penjualan', $id_sp)->where('qty', '!=', 0)->get();
    //     }
    // }
}
