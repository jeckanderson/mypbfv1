<?php

namespace App\Livewire\KeuanganAkutansi\Piutang;

use App\Models\Jurnal;
use Livewire\Component;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PiutangAwal;
use App\Models\AkunAkutansi;
use App\Models\PiutangPengguna;
use App\Models\TagihanPelanggan;
use App\Models\PembayaranPiutang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TambahPembayaranPiutang extends Component
{
    public $pelanggans = [], $tagihans = [], $tagihanPengguna = [], $pilihTagihan, $pelanggan, $piutangPengguna = [], $piutangPengguna2 = [], $metode = '', $error = [], $akuns = [], $disabled;

    public $no_reff, $tgl_input, $akun_bayar, $keterangan, $bayar = [], $sisa = [], $sisa_hutang = [], $total_bayar, $id;

    public function render()
    {
        return view('livewire.keuangan-akutansi.piutang.tambah-pembayaran-piutang');
    }

    public function mount()
    {
        if ($this->id) {
            $bayar = PembayaranPiutang::find($this->id);
            $this->metode = 'tagihan';
            $this->no_reff = $bayar->no_reff;
            $this->tgl_input = $bayar->tgl_input;
            $this->keterangan = $bayar->ketarangan;
            $this->akun_bayar = AkunAkutansi::find($bayar->akun_bayar)->nama_akun;

            $this->piutangPengguna2 = PiutangPengguna::where('id_bp', $this->id)->get();
            $this->tagihanPengguna = TagihanPelanggan::find($bayar->id_pilihan);
        } else {
            $lastOrder = PembayaranPiutang::latest()->first();

            if ($lastOrder) {
                $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
                $nextOrderNumber = intval($lastOrderNumber) + 1;
            } else {
                $nextOrderNumber = 1;
            }

            $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
            $this->no_reff = $urutan . '/PP/' . date('m-y');
            $this->tgl_input = now()->toDateString();
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

            $this->pelanggans = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
            $this->tagihans = TagihanPelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)
                ->whereNotIn('id', PembayaranPiutang::where('metode', 'tagihan')->pluck('id_pilihan'))
                ->get();
        }
    }

    public function updatedPelanggan()
    {
        $hasil = PiutangPengguna::where('id_pelanggan', $this->pelanggan)
            ->select('id_penjualan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_penjualan')
            ->get()
            ->pluck('max_id');

        $this->piutangPengguna = PiutangPengguna::whereIn('id', $hasil)
            ->get();
    }

    public function updatedPilihTagihan()
    {
        if ($this->pilihTagihan) {
            $this->tagihanPengguna = TagihanPelanggan::find($this->pilihTagihan);
            $this->piutangPengguna2 = PiutangPengguna::whereIn('id', json_decode($this->tagihanPengguna->id_piutang))->where('sisa_hutang', '!=', 0)->get();
            $this->bayar = array_fill(0,  $this->piutangPengguna2->count(), 0);
            foreach ($this->piutangPengguna2 as $index => $jumlah) {
                $this->hitungJumlah($index);
            };
        } else {
            $this->tagihanPengguna = '';
            $this->piutangPengguna2 = '';
        }
    }

    public function updatedMetode()
    {
        $this->disabled = 'disabled';
    }

    public function hitungJumlah($index)
    {
        $bayar = str_replace('.', '', $this->bayar[$index]);
        if ($this->metode == 'pelanggan') {
            $this->sisa_hutang[$index] = ($this->piutangPengguna[$index]->sisa_hutang) - $bayar;
        } else {
            $this->sisa_hutang[$index] = ($this->piutangPengguna2[$index]->sisa_hutang) - $bayar;
        }
        $this->sisa_hutang[$index] = doubleval($this->sisa_hutang[$index]);
        $this->sisa[$index] = number_format($this->sisa_hutang[$index], 0, ',', '.');
        if ($this->sisa_hutang[$index] < 0) {
            $this->error[$index] = 'Nominal yang dimasukan tidak boleh lebih dari sisa hutang tersedia';
        } else {
            $this->error[$index] = '';
        }
        $this->total_bayar = 0;
        foreach ($this->bayar as $bayar) {
            $this->total_bayar += str_replace('.', '', $bayar);
        }
        $this->total_bayar = doubleval($this->total_bayar);
        $this->total_bayar = number_format($this->total_bayar, 0, ',', '.');
    }

    public function simpanPembayaranPiutang()
    {
        if (!$this->akun_bayar) {
            $this->js("alert('Pilih akun bayar terlebih dahulu')");
            return;
        }
        DB::beginTransaction();
        try {
            $lastOrder = PembayaranPiutang::latest()->first();

            if ($lastOrder) {
                $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
                $nextOrderNumber = intval($lastOrderNumber) + 1;
            } else {
                $nextOrderNumber = 1;
            }

            $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
            if ($this->metode == 'tagihan') {
                $tagihan = $this->tagihanPengguna->id_piutang;
                $simpan = PembayaranPiutang::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $urutan . '/PP/' . date('m-y'),
                    'tgl_input' => $this->tgl_input,
                    'metode' => $this->metode,
                    'id_pilihan' => $this->pilihTagihan,
                    'akun_bayar' => $this->akun_bayar,
                    'total_bayar' => str_replace('.', '', $this->total_bayar),
                    'id_piutang' => $tagihan,
                    'keterangan' => $this->keterangan
                ]);
            } else {
                $simpan = PembayaranPiutang::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' => $urutan . '/PP/' . date('m-y'),
                    'tgl_input' => $this->tgl_input,
                    'metode' => $this->metode,
                    'id_pilihan' => $this->pelanggan,
                    'akun_bayar' => $this->akun_bayar,
                    'total_bayar' => str_replace('.', '', $this->total_bayar),
                    'id_piutang' => '',
                    'keterangan' => $this->keterangan
                ]);
            }


            if ($this->metode == 'tagihan') {


                foreach ($this->sisa_hutang as $index => $sisa) {
                    $piutang = $simpan->piutang_pengguna()->create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_bp' => $simpan->id,
                        'sumber' =>  $this->piutangPengguna2[$index]->sumber,
                        'sourceable_type' => $this->piutangPengguna2[$index]->sourceable_type,
                        'sourceable_id' => $this->piutangPengguna2[$index]->sourceable_id,
                        'id_penjualan' => $this->piutangPengguna2[$index]->id_penjualan,
                        'id_pelanggan' => $this->piutangPengguna2[$index]->id_pelanggan,
                        'akun_akutansi_id' => $simpan->akun_bayar,
                        'nominal_bayar' => str_replace('.', '', $this->bayar[$index]),
                        'total_hutang' => $this->piutangPengguna2[$index]->total_hutang,
                        'sisa_hutang' => str_replace('.', '', $this->sisa[$index]),
                    ]);
                    $id_piutang[] = $piutang->id;
                }
            } else {
                $id_piutang = [];

                foreach ($this->sisa_hutang as $index => $sisa) {
                    if ($this->bayar[$index] != null && $this->bayar[$index] != 0) {
                        $class = $this->piutangPengguna[$index]->sumber == 'penjualan' ? Penjualan::class : PiutangAwal::class;
                        $piutang = $simpan->piutang_pengguna()->create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'id_bp' => '-',
                            'sumber' =>  $this->piutangPengguna[$index]->sumber,
                            'sourceable_type' => $class,
                            'akun_akutansi_id' => $simpan->akun_bayar,
                            'sourceable_id' => $this->piutangPengguna[$index]->id_penjualan,
                            'id_penjualan' => $this->piutangPengguna[$index]->id_penjualan,
                            'id_pelanggan' => $this->piutangPengguna[$index]->id_pelanggan,
                            'nominal_bayar' => str_replace('.', '', $this->bayar[$index]),
                            'total_hutang' => $this->piutangPengguna[$index]->total_hutang,
                            'sisa_hutang' => str_replace('.', '', $this->sisa[$index]),
                        ]);
                        $id_piutang[] = $piutang->id;
                    }
                    $simpan->update(['id_piutang' => json_encode($id_piutang)]);
                }



                // Ubah id_bp menjadi id dari $simpan
                foreach ($id_piutang as $id) {
                    $piutang = PiutangPengguna::find($id);
                    $piutang->id_bp = $simpan->id;
                    $piutang->save();
                }
            }

            //hutang dagang dan konsi
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $urutan . '/PP/' . date('m-y'),
                'kode_akun' => AkunAkutansi::find(1)->kode,
                'id_sumber' => $simpan->id,
                'sumber' => 'Pembayaran Piutang',
                'keterangan' => 'Pembayaran Piutang',
                'kredit' => str_replace('.', '', $this->total_bayar),
            ]);
            //kas bank
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $urutan . '/PP/' . date('m-y'),
                'kode_akun' => AkunAkutansi::find($this->akun_bayar)->kode,
                'id_sumber' => $simpan->id,
                'sumber' => 'Pembayaran Piutang',
                'keterangan' => 'Pembayaran Piutang',
                'debet' => str_replace('.', '', $this->total_bayar),
            ]);
            DB::commit();
            return redirect('/pembayaran-piutang');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            //throw $th;
        }
    }
}
