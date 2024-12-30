<?php

namespace App\Livewire\KeuanganAkutansi\JurnalAkun;

use App\Models\DetailJurnalAkun;
use App\Models\JurnalAkun;
use App\Models\Jurnal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TambahJurnalAkun extends Component
{
    public $detailJurnalAkun;
    //masuk form
    public $no_reff, $tgl_input, $keterangan;

    public function render()
    {
        return view('livewire.keuangan-akutansi.jurnal-akun.tambah-jurnal-akun');
    }

    #[On('getJurnalAkun')]
    public function mount()
    {
        $lastOrder = JurnalAkun::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/JA/' . date('m-y');
        $this->tgl_input = now()->toDateString();
        $this->detailJurnalAkun = DetailJurnalAkun::where('id_user', Auth::id())->where('id_ja', '-')->get();
    }

    public function hapusJurnalAkun($id)
    {
        $hapus = DetailJurnalAkun::find($id);
        Jurnal::where('id_sumber', $id)->where('sumber', 'Jurnal Akun')->delete();
        if ($hapus->delete()) {
            $this->mount();
        }
    }

    public function simpanJurnalAkun()
    {
        $lastOrder = JurnalAkun::latest()->first();

        if ($lastOrder) {
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            $nextOrderNumber = 1;
        }

        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $simpan = JurnalAkun::create([
            'id_perusahaan' => Auth::user()->id_perusahaan,
            'id_jurnal' => '-',
            'no_reff' => $urutan . '/JA/' . date('m-y'),
            'tgl_input' => $this->tgl_input,
            'keterangan' => $this->keterangan,
        ]);

        if ($simpan) {
            DetailJurnalAkun::where('id_user', Auth::id())->where('id_ja', '-')->update([
                'id_ja' => $simpan->id
            ]);
            foreach ($simpan->detail_jurnal_akun as $key => $value) {
                Jurnal::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'no_reff' =>  $simpan->no_reff,
                    'kode_akun' => $value->akun->kode,
                    'id_sumber' => $simpan->id,
                    'sumber' => 'Jurnal Akun',
                    'keterangan' => 'Jurnal Akun',
                    'debet' => $value->debet,
                    'kredit' => $value->kredit,
                ]);
            }
            return redirect('/jurnal-akun');
        }
    }
}
