<?php

namespace App\Livewire\KeuanganAkutansi\Kontrabon;

use App\Http\Repositories\PiutangPenggunaRepository;
use App\Models\Kontrabon;
use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\PiutangPengguna;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class TambahKontrabon extends Component
{
    public $pelanggans = [], $salesman = [], $piutangs = [], $id, $cari;
    //masuk form
    public $pelanggan, $sales, $selectedPiutang = [], $no_reff, $tgl_input, $keterangan;

    public function render()
    {
        return view('livewire.keuangan-akutansi.kontrabon.tambah-kontrabon');
    }

    public function mount()
    {
        $lastOrder = Kontrabon::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);

        $this->pelanggans = Pelanggan::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->salesman = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        if ($this->id) {
            $kontrabon = Kontrabon::find($this->id);
            $this->no_reff = $kontrabon->no_reff;
            $this->tgl_input = $kontrabon->tgl_input;
            $this->pelanggan = $kontrabon->pelanggan;
            $this->sales = $kontrabon->sales;
            $this->keterangan = $kontrabon->keterangan;
            $this->updatedPelanggan();
            $this->selectedPiutang = json_decode($kontrabon->id_piutang);
        } else {
            $this->no_reff = $urutan . '/CB/' . date('m-y');
            $this->tgl_input = now()->toDateString();
        }
    }

    public function updatedPelanggan()
    {
        // Query database dan simpan hasilnya dalam koleksi
        $piutang = PiutangPengguna::where('id_pelanggan', $this->pelanggan)
            ->select('id_penjualan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_penjualan')
            ->get()
            ->pluck('max_id');

        // dd($piutang);

        $this->piutangs = PiutangPengguna::whereIn('id', $piutang)
            ->get();

        // dd($this->piutangs);
    }

    public function updatedCari()
    {
        $piutang = PiutangPengguna::where('id_pelanggan', $this->pelanggan)
            ->select('id_penjualan', DB::raw('MAX(id) as max_id'))
            ->groupBy('id_penjualan')
            ->get()
            ->pluck('max_id');

        if ($this->cari) {
            $this->piutangs = PiutangPengguna::where('id_pelanggan', $this->pelanggan)->whereIn('id', $piutang)
                ->whereHas('sourceable', function ($q) {
                    $q->where('no_faktur', 'like', '%' . $this->cari . '%');
                })
                ->get();
        } else {
            $this->piutangs = PiutangPengguna::whereIn('id', $piutang)
                ->where('sisa_hutang', '!=', 0)
                ->get();
        }
    }


    public function simpanKontrabon()
    {
        $lastOrder = Kontrabon::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        if ($this->id) {
            $simpanEdit = Kontrabon::find($this->id)->update([
                'tgl_input' => $this->tgl_input,
                'pelanggan' => $this->pelanggan,
                'sales' => $this->sales,
                'id_piutang' => json_encode($this->selectedPiutang),
                'keterangan' => $this->keterangan,
            ]);
            if ($simpanEdit) {
                return redirect('/kontrabon');
            }
        } elseif ($this->selectedPiutang) {
            $simpan = Kontrabon::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $urutan . '/CB/' . date('m-y'),
                'tgl_input' => $this->tgl_input,
                'pelanggan' => $this->pelanggan,
                'sales' => $this->sales,
                'id_piutang' => json_encode($this->selectedPiutang),
                'keterangan' => $this->keterangan,
            ]);
            if ($simpan) {
                return redirect('/kontrabon');
            }
        } else {
            $this->js("alert('Belum ada piutang yang dipilih!')");
        }
    }
}
