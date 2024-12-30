<?php

namespace App\Livewire\Persediaan\StockOpname;

use App\Models\DiskonKelompok;
use App\Models\Gudang;
use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\Kelompok;
use App\Models\ObatBarang;
use App\Models\Rak;
use App\Models\SetHarga;
use App\Models\StokOpname;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahStokMasuk extends Component
{
    public $produks = [], $gudangs = [], $raks = [], $subRak = [], $sumber, $disabled;
    //masuk form
    public $produk, $tipe, $batch, $exp_date, $satuan, $isi, $satuan_terkecil, $hpp, $stok_tercatat, $stok_real, $gudang, $rak, $subrak, $keterangan, $tanggal_so;

    public function render()
    {
        return view('livewire.persediaan.stock-opname.tambah-stok-masuk');
    }

    public function updatedProduk()
    {
        $produk = ObatBarang::find($this->produk);
        $this->tipe = $produk->tipe;
        if ($produk->exp_date == 1) {
            $this->exp_date = now()->toDateString();
            $this->disabled = '';
        } else {
            $this->exp_date = '-';
            $this->disabled = 'disabled';
        }
        $this->satuan = $produk->satuanDasar->satuan;
        $this->isi = $produk->isi;
        $this->satuan_terkecil = $produk->satuanTerkecil->satuan;
        $this->stok_tercatat = 0;
    }

    public function mount()
    {
        $this->produks = ObatBarang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->gudangs = Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->raks = Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->subRak = SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->tanggal_so = now()->toDateString();
    }

    public function simpanDataOpname()
    {
        if (!$this->batch) {
            $this->js('alert("Nomor Batch tidak boleh kosong")');
            return;
        }
        try {
            $lastOrder = HistoryStok::latest()->first();

            if ($lastOrder) {
                $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
                $nextOrderNumber = intval($lastOrderNumber) + 1;
            } else {
                $nextOrderNumber = 1;
            }

            $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
            $histori = HistoryStok::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_produk' => $this->produk,
                'no_reff' => $urutan . '/SO/' . date('m-y'),
                'no_faktur' => '-',
                'no_batch' => $this->batch,
                'exp_date' => $this->exp_date,
                'suplier_pelanggan' => '-',
                'id_gudang' => $this->gudang,
                'id_rak' => $this->rak,
                'id_sub_rak' => $this->subrak,
                'stok_masuk' => $this->stok_real,
                'stok_keluar' => 0,
                'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_produk', $this->produk)->where('id_gudang', $this->gudang)->where('id_rak', $this->rak)->where('id_sub_rak', $this->subrak)->latest()->first()->stok_akhir ?? 0) + $this->stok_real,
                'keterangan' => 'Stok Masuk'
            ]);
            if ($histori) {
                $opname = StokOpname::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_histori' => $histori->id,
                    'sumber' => 'Stok Masuk',
                    'tgl_so' => $this->tanggal_so,
                    'no_reff' => $urutan . '/SO/' . date('m-y'),
                    'id_produk' => $this->produk,
                    'no_batch' => $this->batch,
                    'exp_date' => $this->exp_date ?? '-',
                    'stok_tercatat' => 0,
                    'stok_real' => $this->stok_real,
                    'selisih_stok' => $this->stok_real,
                    'hpp' => $this->hpp,
                    'nominal_selisih' => (str_replace('.', '', $this->hpp) / $this->isi) * $this->stok_real,
                    'keterangan' => $this->keterangan ?? '-',
                    'gudang' => $this->gudang,
                    'rak' => $this->rak,
                    'sub_rak' => $this->subrak,
                ]);

                $histori->update([
                    'sumber_set_harga' => 'Stok Masuk',
                    'id_set_harga' => $opname->id,
                ]);

                foreach (Kelompok::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $kelompok) {
                    foreach (DiskonKelompok::where('id_kelompok', $kelompok->id)->where('satuan_dasar_beli', '!=', null)->where('id_obat_barang', $opname->id_produk)->get() as $disc) {
                        $hpp_final =
                            (str_replace('.', '', $opname->hpp) / $opname->produk->isi) *
                            $disc->isi;

                        $persentase = $disc->persentase;
                        $disc_1 = $disc->disc_1;
                        $disc_2 = $disc->disc_2;
                        $hasil_laba = round($hpp_final * (1 + $persentase / 100));
                        $harga1 = $hasil_laba - ($hasil_laba * $disc_1) / 100;
                        $harga_jual = round($harga1 - ($harga1 * $disc_2) / 100);
                        SetHarga::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'id_set_harga' => $opname->id,
                            'sumber' => 'Stok Masuk',
                            'id_produk' => $opname->id_produk,
                            'id_kelompok' => $kelompok->id,
                            'id_set' => $disc->id_set_harga,
                            'id_jumlah' => 1,
                            'satuan' => $disc->satuan_dasar_beli,
                            'jumlah' =>  '-',
                            'sampai' => '-',
                            'isi' => $disc->isi,
                            'hpp_final' => $hpp_final,
                            'laba' => $persentase,
                            'hasil_laba' =>  $hasil_laba,
                            'disc_1' => $disc_1,
                            'disc_2' => $disc_2,
                            'harga_jual' => $harga_jual,
                        ]);
                    }
                }

                if ($opname) {
                    //pendapatan stok opname
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '7-1010',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opaname',
                        'keterangan' => 'Stok Opaname',
                        'kredit' => (str_replace('.', '', $this->hpp) / $this->isi) * $this->stok_real,
                    ]);

                    //persediaan dagang dan konsi
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '1-2001',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'debet' => (str_replace('.', '', $this->hpp) / $this->isi) * $this->stok_real,
                    ]);
                }
            }
            session()->flash('success', 'Stok opname berhasil ditambahkan');
        } catch (\Exception $e) {
            $this->js("alert('eror')");
        }

        $this->dispatch('refresh');
    }
}
