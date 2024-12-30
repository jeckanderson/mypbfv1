<?php

namespace App\Livewire\Penjualan\ReturPenjualan;

use App\Models\AkunAkutansi;
use App\Models\DiskonKelompok;
use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\Penjualan;
use App\Models\PiutangPengguna;
use App\Models\PPN;
use App\Models\ProdukPenjualan;
use App\Models\ProdukReturPenjualan;
use App\Models\ReturPenjualan;
use App\Models\SetHarga;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class TambahReturPenjualan extends Component
{
    public $dataPenjualan, $id_penjualan, $produkPenjualan = [], $total_retur = 0, $tambahPenjualan, $harga = [], $pengurangan, $piutang;
    //masuk form
    public $no_reff, $pelanggan, $id_pelanggan, $sales, $id_sales, $no_faktur, $tanggal_input, $no_seri_pajak, $qty = [], $total_piutang, $sisa_piutang, $uang_retur, $dpp, $ppn, $total, $akun;

    public function render()
    {
        return view('livewire.penjualan.retur-penjualan.tambah-retur-penjualan', [
            'akunTetap' => AkunAkutansi::where('is_delete', 0)
                ->orderBy('kode', 'asc')
                ->where('kas_bank', 1)
                ->get(),
            'akuns' => AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('is_delete', 1)
                ->where('kas_bank', 1)
                ->orderBy('kode', 'asc')
                ->get(),
            'penjualans' => Penjualan::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function updatedTambahPenjualan()
    {
        $this->id_penjualan = $this->tambahPenjualan;
        $dataPenjualan = Penjualan::find($this->tambahPenjualan);
        $this->no_reff = $dataPenjualan->no_reff;
        $this->pelanggan = $dataPenjualan->getPelanggan->nama;
        $this->id_pelanggan = $dataPenjualan->pelanggan;
        $this->sales = $dataPenjualan->getSales->nama_pegawai;
        $this->id_sales = $dataPenjualan->sales;
        $this->no_faktur = $dataPenjualan->no_faktur;
        $this->tanggal_input = $dataPenjualan->tgl_input;
        $this->no_seri_pajak = $dataPenjualan->no_seri_pajak;
        $this->produkPenjualan = ProdukPenjualan::where('id_penjualan', $this->tambahPenjualan)->get();
        $this->qty = array_fill(0, ProdukPenjualan::where('id_penjualan', $this->tambahPenjualan)->count(), 0);
    }

    public function hitungJumlah($index)
    {
        $allQty = $sum = array_sum($this->qty);
        $produk_penjualan = $this->produkPenjualan[$index];
        // $harga_temp = SetHarga::where('id_produk', $produk_penjualan->id_produk)
        //     ->where('satuan', $produk_penjualan->satuan)
        //     ->where('id_kelompok', $produk_penjualan->penjualan->customer->kelompokPelanggan->id)
        //     ->first();
        $this->piutang = PiutangPengguna::where('id_pelanggan', $this->id_pelanggan)->latest()->first();
        $this->total_piutang = $this->piutang->sisa_hutang;
        $disc_bawah = ($this->produkPenjualan[$index]->penjualan->hasil_diskon / $allQty); // belum tahu darimana // dari data penjualan 
        $h = ($this->produkPenjualan[$index]->harga - ($this->produkPenjualan[$index]->harga  * ($this->produkPenjualan[$index]->disc_1 / 100)));
        $h = ($h - ($h * ($this->produkPenjualan[$index]->disc_2 / 100)));
        $this->harga[$index] = intval(round($h) * $this->qty[$index]) - ($disc_bawah * $this->qty[$index]);
        $this->dpp = array_sum($this->harga);
        // $this->dpp = array_sum($this->harga) -  ($disc_bawah * $this->qty[$index]);
        $ppn = PPN::where('id', Auth::user()->id_perusahaan)->first()->ppn;
        $this->ppn = round($this->dpp * ($ppn / 100));
        $this->total = $this->dpp + $this->ppn;

        $this->pengurangan = $this->total_piutang - $this->total;
        if ($this->pengurangan < 0) {
            $this->uang_retur = abs($this->pengurangan);
            $this->sisa_piutang = 0;
        } else {
            $this->sisa_piutang = $this->pengurangan;
            $this->uang_retur = 0;
        }
    }

    function updateAngka()
    {
        $allQty = array_sum($this->qty);
        foreach ($this->qty as $index => $value) {
            $produk_penjualan = $this->produkPenjualan[$index];
            // $harga_temp = SetHarga::where('id_produk', $produk_penjualan->id_produk)
            //     ->where('satuan', $produk_penjualan->satuan)
            //     ->where('id_kelompok', $produk_penjualan->penjualan->customer->kelompokPelanggan->id)
            //     ->first();
            $this->piutang = PiutangPengguna::where('id_pelanggan', $this->id_pelanggan)->latest()->first();
            $this->total_piutang = $this->piutang->sisa_hutang;
            $disc_bawah = ($this->produkPenjualan[$index]->penjualan->hasil_diskon / $allQty); // belum tahu darimana // dari data penjualan 
            $h = ($this->produkPenjualan[$index]->harga - ($this->produkPenjualan[$index]->harga  * ($this->produkPenjualan[$index]->disc_1 / 100)));
            $h = ($h - ($h * ($this->produkPenjualan[$index]->disc_2 / 100)));
            $this->harga[$index] = intval(round($h) * $value) - ($disc_bawah * $value);
            $this->dpp = array_sum($this->harga);
            // $this->dpp = array_sum($this->harga) -  ($disc_bawah * $value);
            $ppn = PPN::where('id', Auth::user()->id_perusahaan)->first()->ppn;
            $this->ppn = round($this->dpp * ($ppn / 100));
            $this->total = $this->dpp + $this->ppn;

            $this->pengurangan = $this->total_piutang - $this->total;
            if ($this->pengurangan < 0) {
                $this->uang_retur = abs($this->pengurangan);
                $this->sisa_piutang = 0;
            } else {
                $this->sisa_piutang = $this->pengurangan;
                $this->uang_retur = 0;
            }
        }
    }
    public function simpanReturPenjualan()
    {
        if ($this->dpp) {
            $historiIds = [];
            $totals = 0;
            foreach ($this->qty as $index => $retur) {
                if ($retur != 0) {
                    $stok = HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
                        ->where('id_produk', $this->produkPenjualan[$index]->id_produk)
                        ->where('id_gudang', $this->produkPenjualan[$index]->gudang)
                        ->where('id_rak', $this->produkPenjualan[$index]->rak)
                        ->where('id_sub_rak', $this->produkPenjualan[$index]->sub_rak);

                    $stokAkhir = $stok->sum('stok_masuk') - $stok->sum('stok_keluar');

                    $getIsi = DiskonKelompok::where('satuan_dasar_beli', $this->produkPenjualan[$index]->satuan)
                        ->where('id_obat_barang', $this->produkPenjualan[$index]->id_produk)
                        ->first()->isi;

                    $histori = HistoryStok::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_produk' => $this->produkPenjualan[$index]->id_produk,
                        'no_reff' => $this->no_reff,
                        'no_faktur' => $this->produkPenjualan[$index]->penjualan->no_faktur,
                        'no_batch' => $this->produkPenjualan[$index]->batch,
                        'exp_date' => $this->produkPenjualan[$index]->exp_date ?? '-',
                        'suplier_pelanggan' => $this->id_pelanggan,
                        'id_gudang' => $this->produkPenjualan[$index]->gudang,
                        'id_rak' => $this->produkPenjualan[$index]->rak,
                        'id_sub_rak' => $this->produkPenjualan[$index]->sub_rak,
                        'sumber_set_harga' => $this->produkPenjualan[$index]->historiCekSp->sumber_set_harga,
                        'id_set_harga' => $this->produkPenjualan[$index]->historiCekSp->id_set_harga,
                        'stok_masuk' => $retur * $getIsi,
                        'stok_keluar' => 0,
                        'stok_akhir' => $stokAkhir - ($retur * $getIsi),
                        'keterangan' => 'Retur Penjualan'
                    ]);

                    // $set_harga = SetHarga::where('id_produk', $this->produkPenjualan[$index]->id_produk)->where('satuan', $this->produkPenjualan[$index]->satuan)->orderBy('id', 'desc')->first();
                    // $hpp = doubleval($set_harga->hpp_final) / $set_harga->isi;
                    $hpp = doubleval($this->produkPenjualan[$index]->histori->hpp($this->produkPenjualan[$index]->histori));
                    $totals += ($hpp * $this->produkPenjualan[$index]->histori->produk->isi) * $retur;
                    $returPenjualan = ProdukReturPenjualan::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_user' => Auth::id(),
                        'id_histori' => $histori->id,
                        'id_penjualan' => $this->id_penjualan,
                        'id_produk' => $this->produkPenjualan[$index]->produk->id,
                        'hpp' => $hpp * $this->produkPenjualan[$index]->histori->produk->isi,
                        'id_produk_penjualan' => $this->produkPenjualan[$index]->id,
                        'qty_retur' => $retur
                    ]);
                    $historiIds[] = $histori->id;
                    $produkRetur[] = $returPenjualan;
                }
            }

            $retur = ReturPenjualan::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_penjualan' => $this->id_penjualan,
                'id_histori' => json_encode($historiIds),
                'no_reff' => $this->no_reff,
                'pelanggan' => $this->id_pelanggan,
                'sales' => $this->id_sales,
                'no_faktur' => $this->no_faktur,
                'tgl_input' => $this->tanggal_input,
                'total_piutang' => $this->total_piutang,
                'sisa_piutang' => $this->sisa_piutang ?? 0,
                'uang_retur' => $this->uang_retur ?? 0,
                'akun' => $this->akun,
                'dpp' => $this->dpp,
                'ppn' => $this->ppn,
                'total' => $this->total,
                'no_seri_pajak' => $this->no_seri_pajak,
            ]);

            if ($retur) {

                $returPenjualan->update(['id_retur' => $retur->id]);
                $retur->piutang_pengguna()->create(
                    [
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_penjualan' => $this->id_penjualan,
                        'sumber' => 'retur penjualan',
                        'id_bp' => $retur->id,
                        'sourceable_type' => Penjualan::class,
                        'sourceable_id' => $this->id_penjualan,
                        'id_pelanggan' => $this->id_pelanggan,
                        'nominal_bayar' => $retur->total,
                        'total_hutang' => $this->piutang->total_hutang,
                        'sisa_hutang' => $this->pengurangan < 0 ? 0 : $this->pengurangan,
                        'akun_akutansi_id' => $this->akun
                    ]
                );

                //persediaan dagang dan konsi 1-2001
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(3)->kode,
                    'id_sumber' => $retur->id,
                    'sumber' => 'Retur Penjualan',
                    'keterangan' => 'Retur Penjualan',
                    'debet' => $totals,
                ]);

                //hpp dagang dan konsi 5-1001
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(34)->kode,
                    'id_sumber' => $retur->id,
                    'sumber' => 'Retur Penjualan',
                    'keterangan' => 'Retur Penjualan',
                    'kredit' => $totals,
                ]);

                //retur penjualan 4-1002
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(60)->kode,
                    'id_sumber' => $retur->id,
                    'sumber' => 'Retur Penjualan',
                    'keterangan' => 'Retur Penjualan',
                    'debet' => $this->dpp
                ]);

                //ppn keluaran 2-3001
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(24)->kode,
                    'id_sumber' => $retur->id,
                    'sumber' => 'Retur Penjualan',
                    'keterangan' => 'Retur Penjualan',
                    'debet' => $this->ppn,
                ]);
                //pendapatan dagang & consigment
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(1)->kode,
                    'id_sumber' => $retur->id,
                    'sumber' => 'Retur Penjualan',
                    'keterangan' => 'Retur Penjualan',
                    'kredit' => $this->total - $this->uang_retur,
                ]);

                if ($this->akun) {
                    //kas bank
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' =>  $this->no_reff,
                        'kode_akun' => AkunAkutansi::find($this->akun)->kode,
                        'id_sumber' => $retur->id,
                        'sumber' => 'Retur Penjualan',
                        'keterangan' => 'Retur Penjualan',
                        'debet' => $this->uang_retur,
                    ]);
                }
            }
            return redirect('/retur-penjualan');
        } else {
            $this->js("alert('Lengkapi isian terlebih dahulu!')");
        }
    }
}
