<?php

namespace App\Livewire\KeuanganAkutansi\MutasiSaldo;

use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use App\Models\MutasiSaldoAkun;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalMutasiSaldo extends Component
{
    public $akuns = [];
    //masuk form
    public $no_reff, $tgl_input, $akun_pengirim, $jumlah_saldo, $akun_penerima, $keterangan;

    public function render()
    {
        return view('livewire.keuangan-akutansi.mutasi-saldo.modal-mutasi-saldo');
    }

    #[On('dataTerhapus')]
    public function mount()
    {
        $lastOrder = MutasiSaldoAkun::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/MSA/' . date('m-y');
        $this->tgl_input = now()->toDateString();
        $this->akuns = AkunAkutansi::where('is_delete', 0)
            ->where('kas_bank', 1)
            ->orderBy('kode', 'asc')
            ->get()->merge(
                AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->where('kas_bank', 1)
                    ->where('is_delete', 1)
                    ->orderBy('kode', 'asc')
                    ->get()
            );
    }

    public function simpanMutasiSaldo()
    {
        $lastOrder = MutasiSaldoAkun::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);

        $simpan = MutasiSaldoAkun::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_jurnal' => '-',
            'no_reff' => $urutan . '/MSA/' . date('m-y'),
            'tgl_input' => $this->tgl_input,
            'akun_pengirim' => $this->akun_pengirim,
            'jumlah_saldo' => str_replace('.', '', $this->jumlah_saldo),
            'akun_penerima' => $this->akun_penerima,
            'keterangan' => $this->keterangan,
        ]);
        if ($simpan) {
            $this->dispatch('dataMutasi');
            $this->reset('jumlah_saldo', 'keterangan');

            //untuk mengambil no referensi terbaru
            $lastOrder = MutasiSaldoAkun::latest()->first();

            if ($lastOrder) {
                $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
                $nextOrderNumber = intval($lastOrderNumber) + 1;
            } else {
                $nextOrderNumber = 1;
            }
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' =>  $simpan->no_reff,
                'kode_akun' => AkunAkutansi::find($this->akun_pengirim)->kode,
                'id_sumber' => $simpan->id,
                'sumber' => 'Mutasi Saldo',
                'keterangan' => 'Mutasi Saldo',
                'kredit' => $simpan->jumlah_saldo,
            ]);
            Jurnal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' =>  $simpan->no_reff,
                'kode_akun' => AkunAkutansi::find($this->akun_penerima)->kode,
                'id_sumber' => $simpan->id,
                'sumber' => 'Mutasi Saldo',
                'keterangan' => 'Mutasi Saldo',
                'debet' => $simpan->jumlah_saldo,
            ]);
            $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
            session()->flash('success', 'Data berhasil disimpan!');
            $this->no_reff = $urutan . '/MSA/' . date('m-y');
            $this->tgl_input = now()->toDateString();
        }
    }
}
