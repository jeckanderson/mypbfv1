<?php

namespace App\Livewire\KeuanganAkutansi\PembayaranHutang;

use App\Models\AkunAkutansi;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\PembayaranHutang;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class TambahPembayaranHutang extends Component
{
    public $error = [], $akuns = [], $id, $akun;
    //masuk form
    public $suplier, $hutangs = [], $tgl_input, $no_reff, $akun_bayar, $keterangan, $bayar = [], $sisa_hutang = [], $sisa = [], $total_bayar;

    public function render()
    {
        return view('livewire.keuangan-akutansi.pembayaran-hutang.tambah-pembayaran-hutang', [
            'supliers' => Suplier::where('id_perusahaan', Auth::user()->id_perusahaan)->get()
        ]);
    }

    public function mount()
    {
        if ($this->id) {
            $bayar = PembayaranHutang::find($this->id);
            $this->keterangan = $bayar->keterangan;
            $this->no_reff = $bayar->no_reff;
            $this->suplier = $bayar->suplier;
            $this->akun = AkunAkutansi::find($bayar->akun_bayar)->nama_akun;
            $this->hutangs = HutangPengguna::where('id_bh', $this->id)->get();
        }
    }

    public function updatedSuplier()
    {
        $data = HutangPengguna::select(DB::raw('MAX(id) as id'))
            ->where('id_suplier', $this->suplier)
            ->groupBy('id_pembelian')
            ->get();
        $result = HutangPengguna::whereIn('id', $data)
            ->where('sisa_hutang', '!=', 0)
            ->get();
        $this->hutangs = $result;
        $this->tgl_input = now()->toDateString();
        $urutan = str_pad(PembayaranHutang::count() + 1, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/PH/' . date('m-y');
        $this->akuns = AkunAkutansi::where('is_delete', 0)
            ->orderBy('kode', 'asc')
            ->where('kas_bank', 1)
            ->get()->merge(
                AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->where('is_delete', 1)
                    ->where('kas_bank', 1)
                    ->orderBy('kode', 'asc')
                    ->get()
            );
    }

    public function hitungJumlah($index)
    {
        $this->sisa_hutang[$index] =  str_replace('.', '', $this->hutangs[$index]->sisa_hutang) - str_replace('.', '', $this->bayar[$index]);
        $this->sisa[$index] = number_format($this->sisa_hutang[$index], 0, ',', '.');
        if (($this->sisa_hutang[$index]) < 0) {
            $this->error[$index] = 'Nominal yang dimasukan tidak boleh lebih dari sisa hutang tersedia';
        } else {
            $this->error[$index] = '';
        }
        $this->total_bayar = 0;
        foreach ($this->bayar as $bayar) {
            $this->total_bayar += str_replace('.', '', $bayar);
        }
    }

    public function simpanHutang()
    {
        if (!$this->bayar) {
            $this->js("alert('Pembayaran hutang masih kosong!')");
        } else {
            $urutan = str_pad(PembayaranHutang::count() + 1, 6, '0', STR_PAD_LEFT);
            $simpanHutang = PembayaranHutang::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'tgl_input' => $this->tgl_input,
                'no_reff' => $urutan . '/PH/' . date('m-y'),
                'suplier' => $this->suplier,
                'akun_bayar' => $this->akun_bayar,
                'total_bayar' => $this->total_bayar,
                'keterangan' => $this->keterangan
            ]);

            if ($simpanHutang) {
                //hutang dagang dan konsi
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $urutan . '/PH/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find(6)->kode,
                    'id_sumber' => $simpanHutang->id,
                    'sumber' => 'Pembayaran Hutang',
                    'keterangan' => 'Pembayaran Hutang',
                    'debet' => $this->total_bayar,
                ]);
                //kas bank
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $urutan . '/PH/' . date('m-y'),
                    'kode_akun' => AkunAkutansi::find($this->akun_bayar)->kode,
                    'id_sumber' => $simpanHutang->id,
                    'sumber' => 'Pembayaran Hutang',
                    'keterangan' => 'Pembayaran Hutang',
                    'kredit' => $this->total_bayar,
                ]);
                foreach ($this->sisa_hutang as $index => $sisa) {
                    if ($this->bayar[$index] != null && $this->bayar[$index] != 0) {
                        $dataHutang = [
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'sumber' => 'pembayaran hutang',
                            'id_bh' => $simpanHutang->id,
                            'id_pembelian' => $this->hutangs[$index]->id_pembelian,
                            'sourceable_id' => $this->hutangs[$index]->sourceable_id,
                            'sourceable_type' => $this->hutangs[$index]->sourceable_type,
                            'id_suplier' => $this->hutangs[$index]->id_suplier,
                            'nominal_bayar' => $this->bayar[$index],
                            'total_hutang' => $this->hutangs[$index]->total_hutang,
                            'sisa_hutang' => $this->sisa[$index],
                        ];
                        if ($simpanHutang->akun_bayar) {
                            $dataHutang += [
                                'akun_akutansi_id' => $simpanHutang->akun->id
                            ];
                        }
                        $simpanHutang->hutang_pengguna()->create($dataHutang);
                    }
                }
                return redirect('/pembayaran-hutang');
            }
        }
    }
}
