<?php

namespace App\Livewire\KeuanganAkutansi\Tagihan;

use App\Http\Repositories\PiutangPenggunaRepository;
use App\Models\AreaRayon;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\PiutangPengguna;
use App\Models\TagihanPelanggan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahTagihan extends Component
{
    public $rayons = [], $cari, $dataTagihan = [], $id, $kolektors, $unChecked = [];
    //masuk form
    public $area_rayon = "", $no_reff, $tgl_input, $keterangan, $selectedPiutang = [], $kolektor;

    public function render(PiutangPenggunaRepository $piutangPenggunaRepository)
    {
        $this->dataTagihan = $piutangPenggunaRepository->getLatestPiutang(area: $this->area_rayon, search: $this->cari, kolektor: $this->kolektor);

        return view('livewire.keuangan-akutansi.tagihan.tambah-tagihan');
    }

    public function mount()
    {
        $this->unChecked = TagihanPelanggan::pluck('id_piutang')
            ->map(function ($item) {
                return json_decode($item, true);
            })->flatten()->unique()->toArray();

        $lastOrder = TagihanPelanggan::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        if ($this->id) {
            $tagihan = TagihanPelanggan::find($this->id);
            $this->no_reff = $tagihan->no_reff;
            $this->tgl_input = $tagihan->tgl_input;
            $this->keterangan = $tagihan->keterangan;
            $this->kolektor = $tagihan->kolektor;
            $this->area_rayon = $tagihan->area_rayon;
            $this->selectedPiutang = json_decode($tagihan->id_piutang);
        } else {
            $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
            $this->tgl_input = now()->toDateString();
            $this->no_reff = $urutan . '/TP/' . date('m-y');
        }

        $this->rayons = AreaRayon::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->kolektors = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->where('kolektor', 'on')->get();
    }

    public function updatedAreaRayon()
    {
        $getPelanggan = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('area_rayon', $this->area_rayon)
            ->pluck('id')
            ->toArray();

        $this->dataTagihan = PiutangPengguna::whereIn('id_pelanggan', $getPelanggan)->get();
    }

    public function simpanTagihan()
    {
        $lastOrder = TagihanPelanggan::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);

        if ($this->selectedPiutang) {
            if ($this->id) {
                $simpan = TagihanPelanggan::find($this->id)->update([
                    'tgl_input' => $this->tgl_input,
                    'kolektor' => $this->kolektor,
                    'area_rayon' => $this->area_rayon,
                    'id_piutang' => json_encode($this->selectedPiutang),
                    'keterangan' => $this->keterangan
                ]);
            } else {
                $simpan = TagihanPelanggan::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'tgl_input' => $this->tgl_input,
                    'no_reff' => $urutan . '/TP/' . date('m-y'),
                    'kolektor' => $this->kolektor,
                    'area_rayon' => $this->area_rayon,
                    'id_piutang' => json_encode($this->selectedPiutang),
                    'keterangan' => $this->keterangan
                ]);
            }
            if ($simpan) {
                return redirect('/tagihan-pelanggan');
            }
        } else {
            $this->js("alert('Pilih daftar piutang terlebih dahulu!')");
        }
    }
}
