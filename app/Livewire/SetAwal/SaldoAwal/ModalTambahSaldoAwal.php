<?php

namespace App\Livewire\SetAwal\SaldoAwal;

use App\Models\AkunAkutansi;
use App\Models\JurnalTetap;
use App\Models\TempSaldoAwal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ModalTambahSaldoAwal extends Component
{
    public $akuns, $id;
    //masuk form
    public $id_akun, $saldo, $tipeSaldo = 'bertambah';
    public function render()
    {
        return view('livewire.set-awal.saldo-awal.modal-tambah-saldo-awal');
    }

    public function mount()
    {
        $this->akuns = AkunAkutansi::where('is_delete', 0)
            ->whereNotIn('id', [6, 1, 3])
            ->orderBy('kode', 'asc')
            ->get()->merge(
                AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)
                    ->where('is_delete', 1)
                    ->orderBy('kode', 'asc')
                    ->get()
            );
    }

    public function masukanSaldo()
    {
        $saldo = JurnalTetap::where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_akun', $this->id_akun)->first()->saldo ?? 0;
        if ($this->saldo && $this->id_akun) {
            if ($this->tipeSaldo == 'bertambah') {
                $hasilSaldo = $saldo + str_replace('.', '', $this->saldo);
            } else {
                $hasilSaldo = $saldo - str_replace('.', '', $this->saldo);
            }

            $masukan = TempSaldoAwal::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'id_akun' => $this->id_akun,
                'jenis_akun' => AkunAkutansi::find($this->id_akun)->jenis_akun,
                'tipe_saldo' => $this->tipeSaldo,
                'saldo' => $this->tipeSaldo == 'bertambah'
                    ? str_replace('.', '', $this->saldo)
                    : 0 - str_replace('.', '', $this->saldo),
                'saldo_sebelum' => $saldo,
                'saldo_sesudah' => $hasilSaldo,
            ]);

            if ($masukan) {
                // session()->flash('success', 'Data berhasil disimpan!');
                // $this->dispatch('refreshSaldo', id: $masukan->id);
                // $this->reset('saldo', 'id_akun');
                return redirect('/tambah-saldo-awal');
            }
        } else {
            $this->js("alert('Isi keseluruhan kolom terlebih dahulu')");
        }
    }
}
