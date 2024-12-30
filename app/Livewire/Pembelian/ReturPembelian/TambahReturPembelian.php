<?php

namespace App\Livewire\Pembelian\ReturPembelian;

use App\Models\AkunAkutansi;
use App\Models\HistoryStok;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\Pembelian;
use App\Models\PPN;
use App\Models\ProdukDiterima;
use App\Models\ProdukPembelian;
use App\Models\ProdukReturPembelian;
use App\Models\ReturPembelian;
use App\Models\Suplier;
use App\Models\TerimaBarang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class TambahReturPembelian extends Component
{
    public $akuns, $disabled;
    //masuk form
    public $id_pembelian = '', $no_reff, $suplier, $id_suplier, $tanggal, $no_faktur, $no_reff_tb, $produkPilihan = [], $produkRetur = [], $pengurangan, $hutang;
    public  $total_hutang, $sisa_hutang, $uang_retur, $akun_bayar, $dpp, $ppn, $total, $no_seri_pajak, $keterangan, $pilihPembelian, $retur = [], $harga = [], $tambahProduk;

    public function render()
    {
        return view('livewire.pembelian.retur-pembelian.tambah-retur-pembelian', [
            'pembelians' => Pembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereIn('id', ProdukDiterima::where('id_perusahaan', Auth::user()->id_perusahaan)->pluck('id_pembelian'))
                ->get()
        ]);
    }

    #[On('refreshTableRetur')]
    public function mount()
    {
        if ($this->id_pembelian) {
            $this->produkRetur = ProdukReturPembelian::where('id_user', Auth::id())->where('qty_retur', null)->where('id_pembelian', $this->id_pembelian)->get();
        }

        $this->akuns = AkunAkutansi::where(function ($query) {
            $query->where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('kas_bank', '1');
        })->orWhere(function ($query) {
            $query->where('is_delete', 0)
                ->where('kas_bank', 1);
        })->get();
    }

    public function updatedPilihPembelian()
    {
        $pembelian = Pembelian::find($this->pilihPembelian);
        $this->id_pembelian = $this->pilihPembelian;
        $this->no_reff = $pembelian->no_reff;
        $this->suplier = Suplier::find($pembelian->suplier)->nama_suplier;
        $this->id_suplier = $pembelian->suplier;
        $this->tanggal = now()->toDateString();
        $this->no_faktur = $pembelian->no_faktur;
        $this->no_reff_tb = TerimaBarang::where('id_pembelian', $this->pilihPembelian)->first()->no_reff;
        $this->no_seri_pajak = $pembelian->no_faktur_pajak;
        $this->hutang = HutangPengguna::where('id_suplier', $this->id_suplier)->where('id_pembelian', $this->id_pembelian)->latest()->first();
        $this->total_hutang = doubleval(str_replace('.', '', $this->hutang->sisa_hutang));
        $this->getProduk($this->id_pembelian);
        $this->mount();
    }

    public function getProduk($id_pembelian)
    {
        $stokTerbaru = HistoryStok::select('id', DB::raw('MAX(id) as max_id'))
            ->where('no_reff', Pembelian::find($id_pembelian)->no_reff)
            ->where('keterangan', '!=', 'Penjualan')
            ->groupBy('id_produk', 'id_gudang', 'id_rak', 'id_sub_rak', 'no_batch')
            ->pluck('max_id');

        $list = HistoryStok::whereIn('id', $stokTerbaru)
            ->get();
        $this->produkPilihan = $list->whereNotIn('id', ProdukReturPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)->pluck('id_histori'));
    }

    public function updatedTambahProduk()
    {
        if ($this->tambahProduk) {
            ProdukReturPembelian::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_user' => Auth::id(),
                'id_pembelian' => $this->id_pembelian,
                'id_produk' => HistoryStok::find($this->tambahProduk)->id_produk,
                'id_histori' => $this->tambahProduk,
            ]);
            $this->mount();
            $this->reset('tambahProduk');
            $this->getProduk($this->id_pembelian);
        }
    }

    public function hitungRetur()
    {
        $totalHppFinal = 0;

        foreach ($this->produkRetur as $index => $produkReturItem) {
            $produkPembelian = ProdukPembelian::where('id_pembelian', $produkReturItem->id_pembelian)
                ->where('id_produk', $produkReturItem->id_produk)
                ->first();

            if ($produkPembelian) {
                $hppFinal = $produkPembelian->hpp_final;
                foreach ($this->retur as $returIndex => $returValue) {
                    if ($returIndex == $index) {
                        $totalHppFinal += $hppFinal * $returValue;
                    }
                }
            }
        }

        // Cek total harga
        $ppn = PPN::where('id', Auth::user()->id_perusahaan)->first()->ppn;
        $this->dpp = $totalHppFinal;
        $this->ppn = round($this->dpp * ($ppn / 100));
        $this->total = $this->dpp + $this->ppn;
        //pengurangan total hutang dikurangi total
        $this->pengurangan = $this->total_hutang - $this->total;
        $uang_retur = $this->total - $this->total_hutang;
        $uang_retur = $uang_retur < 0 ? 0 : $uang_retur;
        if ($this->pengurangan < 0) {
            $this->uang_retur = abs($this->pengurangan);
            $this->sisa_hutang = 0;
            $this->disabled = '';
        } else {
            $this->sisa_hutang = $this->pengurangan;
            $this->uang_retur = $uang_retur;
            $this->disabled = 'disabled';
        }
    }


    public function hapusProdukRetur($id)
    {
        $delete = ProdukReturPembelian::find($id)->delete();
        if ($delete) {
            // Refresh the produkRetur array after deletion
            $this->produkRetur = ProdukReturPembelian::where('id_pembelian', $this->id_pembelian)->get();

            // Update the retur array while maintaining the values for other indices
            $newRetur = [];
            foreach ($this->produkRetur as $index => $produkReturItem) {
                // Retain the previous value if it exists, otherwise initialize as needed
                if (isset($this->retur[$index])) {
                    $newRetur[$index] = $this->retur[$index + 1];
                } else {
                    $newRetur[$index] = 0; // Or any default value as needed
                }
            }
            $this->retur = $newRetur;

            // Reinitialize other properties or call mount if necessary
            $this->mount();
            $this->getProduk($this->id_pembelian);
        }
    }

    public function simpanReturPembelian()
    {
        $historiIds = [];
        $this->hitungRetur();
        if ($this->dpp) {
            foreach ($this->retur as $index => $retur) {
                $histori = HistoryStok::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_produk' => $this->produkRetur[$index]->id_produk,
                    'no_reff' => $this->no_reff,
                    'no_faktur' => $this->no_faktur,
                    'no_batch' => $this->produkRetur[$index]->history->no_batch,
                    'exp_date' => $this->produkRetur[$index]->history->exp_date,
                    'suplier_pelanggan' => $this->id_suplier,
                    'id_gudang' => $this->produkRetur[$index]->history->id_gudang,
                    'id_rak' => $this->produkRetur[$index]->history->id_rak,
                    'id_sub_rak' => $this->produkRetur[$index]->history->id_sub_rak,
                    'stok_masuk' => 0,
                    'stok_keluar' => $retur,
                    'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
                        ->where('id_produk', $this->produkRetur[$index]->id_produk)
                        ->where('id_gudang', $this->produkRetur[$index]->history->id_gudang)
                        ->where('id_rak', $this->produkRetur[$index]->history->id_rak)
                        ->where('id_sub_rak', $this->produkRetur[$index]->history->id_sub_rak)
                        ->latest()->first()->stok_akhir ?? 0) - $retur,
                    'keterangan' => 'Retur Pembelian'
                ]);
                $historiIds[] = $histori->id;
            }

            $simpan = ReturPembelian::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_pembelian' => $this->id_pembelian,
                'id_histori' => json_encode($historiIds),
                'no_reff' => $this->no_reff,
                'id_suplier' => $this->id_suplier,
                'tgl_input' => $this->tanggal,
                'no_faktur' => $this->no_faktur,
                'no_reff_tb' => $this->no_reff_tb,
                'total_hutang' => $this->total_hutang,
                'sisa_hutang' => $this->sisa_hutang ?? 0,
                'uang_retur' => $this->uang_retur ?? 0,
                'akun' => $this->akun_bayar ?? '-',
                'dpp' => $this->dpp,
                'ppn' => $this->ppn,
                'total' => round($this->total),
                'no_seri_pajak' => $this->no_seri_pajak,
                'keterangan' => $this->keterangan,
            ]);

            if ($simpan) {
                foreach ($this->retur as $index => $retur) {
                    $this->produkRetur[$index]->update([
                        'id_retur' => $simpan->id,
                        'qty_retur' => $retur,
                    ]);
                }
                //persediaan dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(3)->kode,
                    'id_sumber' => $simpan->id,
                    'sumber' => 'Retur Pembelian',
                    'keterangan' => 'Retur Pembelian',
                    'kredit' => $this->dpp,
                ]);

                //ppn masukan
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(5)->kode,
                    'id_sumber' => $simpan->id,
                    'sumber' => 'Retur Pembelian',
                    'keterangan' => 'Retur Pembelian',
                    'kredit' => $this->ppn,
                ]);

                //Hutang dagang
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $this->no_reff,
                    'kode_akun' => AkunAkutansi::find(6)->kode,
                    'id_sumber' => $simpan->id,
                    'sumber' => 'Retur Pembelian',
                    'keterangan' => 'Retur Pembelian',
                    'debet' => $this->total - $this->uang_retur,
                ]);

                $this->pengurangan = $this->total_hutang - $this->total;
                if ($this->pengurangan < 0) {
                    //kas bank
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $this->no_reff,
                        'kode_akun' => AkunAkutansi::find($this->akun_bayar)->kode,
                        'id_sumber' => $simpan->id,
                        'sumber' => 'Retur Pembelian',
                        'keterangan' => 'Retur Pembelian',
                        'debet' => $this->uang_retur,
                    ]);
                }
                $dataHutang = [
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_pembelian' => $this->id_pembelian,
                    'sumber' => 'retur pembelian',
                    'id_bh' => $simpan->id,
                    'sourceable_type' => Pembelian::class,
                    'sourceable_id' => $this->id_pembelian,
                    'id_suplier' => $this->id_suplier,
                    'nominal_bayar' => $simpan->uang_retur,
                    'total_hutang' => $this->hutang->total_hutang,
                    'sisa_hutang' => $this->pengurangan < 0 ? 0 : round($this->pengurangan)
                ];
                if ($simpan->akun) {
                    $dataHutang += ['akun_akutansi_id' => $simpan->akun->id];
                }
                $simpan->hutang_pengguna()->create($dataHutang);
            }
            return redirect('/retur-pembelian');
        }
    }

    //unused where this is replaced by select because eror snapshot id

    // #[On('pembelianTerpilih')]
    // public function getData($id_pembelian)
    // {
    //     $pembelian = Pembelian::find($id_pembelian);
    //     $this->id_pembelian = $id_pembelian;
    //     $this->no_reff = $pembelian->no_reff;
    //     $this->suplier = $pembelian->suplier;
    //     $this->tanggal = now()->toDateString();
    //     $this->no_faktur = $pembelian->no_faktur;
    //     $this->no_reff_tb = TerimaBarang::where('id_pembelian', $id_pembelian)->first()->no_reff;
    //     $this->no_seri_pajak = $pembelian->no_faktur_pajak;
    //     $this->dispatch('sendDataProduk', id_pembelian: $this->id_pembelian);
    //     $this->mount();
    // }
}
