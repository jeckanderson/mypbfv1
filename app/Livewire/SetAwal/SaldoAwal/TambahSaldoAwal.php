<?php

namespace App\Livewire\SetAwal\SaldoAwal;

use App\Models\AkunAkutansi;
use App\Models\Jurnal;
use App\Models\JurnalTetap;
use App\Models\Profile;
use Livewire\Attributes\On;
use App\Models\TempSaldoAwal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahSaldoAwal extends Component
{
    public $temp_saldo = [];

    #[On('refreshSaldo')]
    public function updateSaldo($id)
    {
        $this->temp_saldo = TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
    }

    public function render()
    {
        $this->temp_saldo = TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        return view('livewire.set-awal.saldo-awal.tambah-saldo-awal', [
            'tgl_saldo' => Profile::where('id_user', Auth::user()->id_perusahaan)->first()->tgl_neraca_awal,
        ]);
    }

    public function hapusSaldo($id)
    {
        $hapus = TempSaldoAwal::find($id)->delete();
        if ($hapus) {
            $this->render();
        }
    }

    public function simpanSaldoAwal()
    {
        $saldoAktiva = TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->where('jenis_akun', 'Aktiva')
            ->sum('saldo');

        $saldoPasiva = TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->whereIn('jenis_akun', ['Kewajiban', 'Modal'])
            ->sum('saldo');

        $jurnalAktiva = JurnalTetap::whereHas('akunAkutansi', function ($query) {
            $query->where('jenis_akun', 'aktiva');
        })->sum('saldo');

        $jurnalPasiva = JurnalTetap::whereHas('akunAkutansi', function ($query) {
            $query->whereIn('jenis_akun', ['kewajiban', 'modal']);
        })->sum('saldo');
        $jumlah1 = $saldoAktiva + $jurnalAktiva;
        $jumlah2 = $saldoPasiva + $jurnalPasiva;

        if ($jumlah1 != $jumlah2) {
            $this->js("alert('Gagal! Saldo aktiva dan pasiva tidak seimbang')");
        } else {
            foreach (TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->get() as $key => $saldo) {
                $jurnal =  JurnalTetap::where('id_akun', $saldo->id_akun)->where('id_perusahaan', Auth::user()->id_perusahaan)->first();
                if ($jurnal) {
                    $jurnal->update([
                        'saldo' => $saldo->saldo_sesudah
                    ]);
                } else {
                    JurnalTetap::create([
                        'id_perusahaan' => Auth::user()->id_perusahaan,
                        'id_akun' => $saldo->id_akun,
                        'saldo' => $saldo->saldo_sesudah
                    ]);
                }
                if ($saldo->jenis_akun == 'Aktiva') {
                    if ($saldo->tipe_saldo == 'bertambah') {
                        Jurnal::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'no_reff' => '-',
                            'kode_akun' => $saldo->akun->kode,
                            'id_sumber' => '-',
                            'sumber' => 'Saldo Awal',
                            'keterangan' => 'Saldo Awal',
                            'debet' => $saldo->saldo,
                        ]);
                    } else {
                        Jurnal::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'no_reff' => '-',
                            'kode_akun' => $saldo->akun->kode,
                            'id_sumber' => '-',
                            'sumber' => 'Saldo Awal',
                            'keterangan' => 'Saldo Awal',
                            'kredit' => $saldo->saldo,
                        ]);
                    }
                } else {
                    if ($saldo->tipe_saldo == 'berkurang') {
                        Jurnal::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'no_reff' => '-',
                            'kode_akun' => $saldo->akun->kode,
                            'id_sumber' => '-',
                            'sumber' => 'Saldo Awal',
                            'keterangan' => 'Saldo Awal',
                            'debet' => $saldo->saldo,
                        ]);
                    } else {
                        Jurnal::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'no_reff' => '-',
                            'kode_akun' => $saldo->akun->kode,
                            'id_sumber' => '-',
                            'sumber' => 'Saldo Awal',
                            'keterangan' => 'Saldo Awal',
                            'kredit' => $saldo->saldo,
                        ]);
                    }
                }
            }
            TempSaldoAwal::where('id_perusahaan', Auth::user()->id_perusahaan)->delete();
            return redirect('/saldo-awal');
        }
    }
}