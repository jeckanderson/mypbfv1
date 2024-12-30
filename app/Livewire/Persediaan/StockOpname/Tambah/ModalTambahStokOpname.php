<?php

namespace App\Livewire\Persediaan\StockOpname\Tambah;

use App\Models\HistoryStok;
use App\Models\Jurnal;
use App\Models\StokAwal;
use App\Models\StokOpname;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahStokOpname extends Component
{
    public $sumber, $stok, $tercatat, $pembelian, $history;

    //masuk form
    public $produk, $tipe, $no_batch, $exp_date, $stok_tercatat, $stok_real, $satuan_terkecil, $gudang, $rak, $subRak, $tanggal_so, $keterangan, $selisih_stok;

    public function render()
    {
        return view('livewire.persediaan.stock-opname.tambah.modal-tambah-stok-opname');
    }

    public function mount()
    {
        $this->produk = $this->history->produk->nama_obat_barang;
        $this->tipe = $this->history->produk->tipe;
        $this->no_batch = $this->history->no_batch;
        $this->exp_date = $this->history->exp_date;
        $this->stok_tercatat = $this->tercatat;
        $this->satuan_terkecil = $this->history->produk->satuanTerkecil->satuan;
        $this->gudang = $this->history->gudang->gudang;
        $this->rak = $this->history->rak->rak;
        $this->subRak = $this->history->subRak->sub_rak;
        $this->tanggal_so = now()->toDateString();
    }

    public function simpanStokOpname()
    {
        $hpp = '';
        $idSumber = '';
        $urutan = str_pad(HistoryStok::count() + 1, 6, '0', STR_PAD_LEFT);
        $difference = $this->stok_real - $this->stok_tercatat;

        $histori = HistoryStok::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_produk' => $this->history->id_produk,
            'no_reff' => $urutan . '/SO/' . date('m-y'),
            'no_faktur' => '-',
            'no_batch' => $this->history->no_batch,
            'exp_date' => ($this->history->exp_date),
            'suplier_pelanggan' => '-',
            'id_gudang' => $this->history->id_gudang,
            'id_rak' => $this->history->id_rak,
            'id_sub_rak' => $this->history->id_sub_rak,
            'sumber_set_harga' => $this->history->sumber_set_harga,
            'id_set_harga' => $this->history->id_set_harga,
            'stok_masuk' => $difference > 0 ? $difference : 0,
            'stok_keluar' => $difference < 0 ? abs($difference) : 0,
            'stok_akhir' => (HistoryStok::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->where('id_produk', $this->history->produk)
                ->where('id_gudang', $this->history->id_gudang)
                ->where('id_rak', $this->history->id_rak)
                ->where('id_sub_rak', $this->history->id_sub_rak)
                ->latest()->first()->stok_akhir ?? 0) + $difference,
            'keterangan' => 'Stok Opname'
        ]);

        if ($histori) {
            $hpp = '';
            $idSumber = '';
            if ($this->history->keterangan == "Stok Awal") {
                $hpp = str_replace('.', '', $this->history->stokAwal->hpp) / (floatval($this->history->stokAwal->isi_satuan));
                $idSumber = $this->history->stokAwal->id;
            } elseif ($this->history->keterangan == "Stok Masuk") {
                $hpp = str_replace('.', '', $this->history->stokMasuk->hpp) / (floatval($this->history->produk->isi));
                $idSumber = $this->history->id_set_harga;
            } elseif ($this->history->keterangan == "Stok Opname" || $this->history->keterangan == "Mutasi Stok") {
                if ($this->history->sumber_set_harga == 'Pembelian') {
                    $hpp = round($this->history->pembelian->diterimaToPembelian->hpp_final);
                    $idSumber = $this->history->id_set_harga;
                } elseif ($this->history->sumber_set_harga == 'Stok Awal') {
                    $hpp = str_replace('.', '', $this->history->stokAwal->hpp) / (floatval($this->history->produk->isi));
                    $idSumber = $this->history->id_set_harga;
                } else {
                    $hpp = str_replace('.', '', $this->history->stokMasuk->hpp) / (floatval($this->history->produk->isi));
                    $idSumber = $this->history->id_set_harga;
                }
            } elseif ($this->history->keterangan == "Pembelian") {
                $hpp = round($this->history->pembelian->diterimaToPembelian->hpp_final);
                $idSumber = $this->history->pembelian->diterimaToPembelian->id;
            } elseif ($this->history->keterangan == "Retur Penjualan") {
                $hpp = str_replace('.', '', $this->history->retur->hpp) / (floatval($this->history->produk->isi));
                $idSumber = $this->history->id_set_harga;
            } elseif ($this->history->keterangan == "Penjualan") {
                $hpp = $this->history->pembelian->diterimaToPembelian->total / (floatval($this->history->produk->isi));
                $idSumber = $this->history->pembelian->diterimaToPembelian->id;
            }

            $opname = StokOpname::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_histori' => $histori->id,
                'tgl_so' => $this->tanggal_so,
                'sumber' => $this->history->keterangan,
                'id_sumber' =>  $idSumber,
                'id_produk' => $this->history->id_produk,
                'no_batch' => $this->history->no_batch,
                'exp_date' => ($this->history->exp_date),
                'stok_tercatat' => $this->tercatat,
                'stok_real' => $this->stok_real,
                'selisih_stok' => $difference,
                'hpp' => $hpp,
                'nominal_selisih' => floatval(str_replace('.', '', $hpp)) * $difference,
                'keterangan' => $this->keterangan,
                'gudang' => $this->history->id_gudang,
                'rak' => $this->history->id_rak,
                'sub_rak' => $this->history->id_sub_rak,
            ]);
            if ($opname) {
                if ($difference < 0) {
                    //kerugian stok opname
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '8-1010',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'debet' => $opname->nominal_selisih * -1,
                    ]);

                    //persediaan dagang dan konsi
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '1-2001',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'kredit' => $opname->nominal_selisih * -1,
                    ]);
                } elseif ($difference > 0) {
                    //pendapatan stok opname
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '7-1010',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'kredit' => $opname->nominal_selisih,
                    ]);

                    //persediaan dagang dan konsi
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '1-2001',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'debet' => $opname->nominal_selisih,
                    ]);
                } elseif ($difference == 0) {
                    //persediaan dagang dan konsi
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '1-2001',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'debet' => 0,
                    ]);

                    //persediaan dagang dan konsi
                    Jurnal::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'no_reff' => $urutan . '/SO/' . date('m-y'),
                        'kode_akun' => '1-2001',
                        'id_sumber' => $opname->id,
                        'sumber' => 'Stok Opname',
                        'keterangan' => 'Stok Opname',
                        'kredit' => 0,
                    ]);
                }
            }
        }


        $this->reset(['stok_real', 'keterangan']);
        session()->flash('success', 'Berhasil!, Stok opname berhasil ditambahkan');
        $this->dispatch('opname-created');
    }
}
