<?php

namespace App\Livewire\Persediaan\MutasiStok;

use App\Models\Gudang;
use App\Models\MutasiStok;
use App\Models\Rak;
use App\Models\SubRak;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahMutasiStok extends Component
{
    public $sumber, $stok, $tercatat, $pembelian;

    //masuk form
    public $produk, $tipe, $no_batch, $exp_date, $stok_tercatat, $stok_real, $satuan_terkecil, $gudang, $rak, $subRak, $tanggal_so, $keterangan, $selisih_stok;

    public function render()
    {
        return view('livewire.persediaan.mutasi-stok.modal-tambah-mutasi-stok', [
            'gudangs' => Gudang::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'raks' => Rak::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
            'subRak' => SubRak::where('id_perusahaan', Auth::user()->id_perusahaan)->get(),
        ]);
    }

    public function mount()
    {
        $this->tanggal_so = now()->toDateString();
        if ($this->sumber == 'stokawal') {
            $this->produk = $this->stok->produk->nama_obat_barang;
            $this->tipe = $this->stok->produk->tipe;
            $this->no_batch = $this->stok->no_batch;
            $this->exp_date = $this->stok->exp_date;
            $this->stok_tercatat = $this->tercatat;
            $this->satuan_terkecil = $this->stok->produk->satuan_jual_terkecil;
            $this->gudang = $this->stok->gudangStok->gudang;
            $this->rak = $this->stok->rakStok->rak;
            $this->subRak = $this->stok->subRak->sub_rak;
        } elseif ($this->sumber == 'pembelian') {
            $this->produk = $this->sumber;
            $this->produk = $this->pembelian->produk->nama_obat_barang;
            $this->tipe = $this->pembelian->produk->tipe;
            $this->no_batch = $this->pembelian->batch;
            $this->exp_date = $this->pembelian->tgl_exp_date;
            $this->stok_tercatat = $this->tercatat;
            $this->satuan_terkecil = $this->pembelian->produk->satuan_jual_terkecil;
            $this->gudang = $this->pembelian->gudangDiterima->gudang;
            $this->rak = $this->pembelian->rakDiterima->rak;
            $this->subRak = $this->pembelian->subRakDiterima->sub_rak;
        }
    }

    public function simpanStokOpname()
    {
        if ($this->sumber == 'stokawal') {
            MutasiStok::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_histori' => '-',
                'tgl_so' => $this->tanggal_so,
                'id_produk' => $this->stok->produk->id,
                'no_batch' => $this->no_batch,
                'exp_date' => $this->exp_date ?? '-',
                'stok_tercatat' => $this->tercatat,
                'stok_real' => $this->stok_real,
                'selisih_stok' => $this->stok_real - $this->stok_tercatat,
                'hpp' => $this->stok->hpp,
                'nominal_selisih' => (str_replace('.', '', $this->stok->hpp) / $this->stok->produk->isi) * ($this->stok_real - $this->stok_tercatat),
                'keterangan' => $this->keterangan,
                'gudang' => $this->stok->gudang,
                'rak' => $this->stok->rak,
                'sub_rak' => $this->stok->sub_rak,
            ]);

            $this->reset(['stok_real', 'keterangan']);
            session()->flash('success', 'Berhasil!, Stok opname berhasil ditambahkan');
        } elseif ($this->sumber == 'pembelian') {
            MutasiStok::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_histori' => '-',
                'tgl_so' => $this->tanggal_so,
                'id_produk' => $this->pembelian->produk->id,
                'no_batch' => $this->no_batch,
                'exp_date' => $this->exp_date ?? '-',
                'stok_tercatat' => $this->tercatat,
                'stok_real' => $this->stok_real,
                'selisih_stok' => $this->stok_real - $this->stok_tercatat,
                'hpp' => $this->pembelian->hpp,
                'nominal_selisih' => (str_replace('.', '', $this->stok->hpp) / $this->stok->produk->isi) * ($this->stok_real - $this->stok_tercatat),
                'keterangan' => $this->keterangan,
                'gudang' => $this->stok->gudang,
                'rak' => $this->stok->rak,
                'sub_rak' => $this->stok->sub_rak,
            ]);

            $this->reset(['stok_real', 'keterangan']);
            session()->flash('success', 'Berhasil!, Stok opname berhasil ditambahkan');
        }
    }
}
