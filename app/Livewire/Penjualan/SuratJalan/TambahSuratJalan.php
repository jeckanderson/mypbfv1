<?php

namespace App\Livewire\Penjualan\SuratJalan;

use App\Models\DetailSuratJalan;
use App\Models\Ekspedisi;
use App\Models\Pegawai;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TambahSuratJalan extends Component
{
    public $pegawais = [], $dataEkspedisi = [], $dataPenjualan = [], $id, $isChangeStatus;
    //masuk form    
    public $no_reff, $tanggal, $sales, $ekspedisi, $keterangan, $status = [];

    public function render()
    {
        return view('livewire.penjualan.surat-jalan.tambah-surat-jalan');
    }

    public function mount()
    {
        $this->pegawais = Pegawai::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->dataEkspedisi = Ekspedisi::where('id_perusahaan', Auth::user()->id_perusahaan)->get();

        if ($this->id) {
            $dataSurat = SuratJalan::find($this->id);
            $this->no_reff = $dataSurat->no_reff;
            $this->tanggal = $dataSurat->tanggal;
            $this->sales = $dataSurat->sales;
            $this->ekspedisi = $dataSurat->ekspedisi;
            $this->keterangan = $dataSurat->keterangan;
            $this->dataPenjualan = DetailSuratJalan::where('id_surat_jalan', $this->id)->get();
            if ($this->isChangeStatus) {
                foreach ($this->dataPenjualan as $key => $item) {
                    $this->status[$key] = $item->status;
                }
            }
        } else {
            $urutan = str_pad(SuratJalan::count() + 1, 6, '0', STR_PAD_LEFT);
            $this->tanggal = now()->toDateString();
            $this->no_reff = $urutan . '/SRJLN/' . date('m-y');
            $this->dataPenjualan = DetailSuratJalan::where('id_user', Auth::id())->where('id_surat_jalan', '-')->get();
        }
    }

    #[On('refreshTablePenjualan')]
    public function refreshTable()
    {
        if ($this->id) {
            $this->dataPenjualan = DetailSuratJalan::where('id_surat_jalan', $this->id)->get();
        } else {
            $this->dataPenjualan = DetailSuratJalan::where('id_user', Auth::id())->where('id_surat_jalan', '-')->get();
        }
    }

    public function hapusDataPenjualan($id)
    {
        $hapus = DetailSuratJalan::find($id)->delete();
        if ($hapus) {
            $this->refreshTable();
        }
    }

    public function simpanSuratJalan()
    {
        if ($this->id) {
            if ($this->isChangeStatus) {
                $detail = DetailSuratJalan::where('id_user', Auth::id())->where('id_surat_jalan', $this->id)->get();
                foreach ($detail as $key => $item) {
                    $item->update(['status' => $this->status[$key]]);
                }
            } else {
                $surat = SuratJalan::find($this->id);
                $surat->update([
                    'no_reff' => $this->no_reff,
                    'tanggal' => $this->tanggal,
                    'sales' => $this->sales,
                    'ekspedisi' => $this->ekspedisi,
                    'keterangan' => $this->keterangan
                ]);
            }
        } else {
            $urutan = str_pad(SuratJalan::count() + 1, 6, '0', STR_PAD_LEFT);
            $simpan = SuratJalan::create([
                'id_perusahaan' => Auth::user()->id_perusahaan,
                'no_reff' => $urutan . '/SRJLN/' . date('m-y'),
                'tanggal' => $this->tanggal,
                'sales' => $this->sales,
                'ekspedisi' => $this->ekspedisi,
                'keterangan' => $this->keterangan ?? '-'
            ]);
            if ($simpan) {
                DetailSuratJalan::where('id_user', Auth::id())->where('id_surat_jalan', '-')->update(['id_surat_jalan' => $simpan->id]);
            }
        }

        return redirect('/surat-jalan');
    }
}
