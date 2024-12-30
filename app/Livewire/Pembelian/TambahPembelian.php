<?php

namespace App\Livewire\Pembelian;

use App\Models\AkunAkutansi;
use App\Models\HutangPengguna;
use App\Models\Jurnal;
use App\Models\Pembelian;
use App\Models\PPN;
use App\Models\ProdukPembelian;
use App\Models\RencanaOrder;
use Livewire\Attributes\On;
use App\Models\SPPembelian;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TambahPembelian extends Component
{
    public $selectedSurat, $surat, $disabled = 'disabled', $active, $hari, $tgl_tempo_kredit, $tgl_faktur, $counts = [], $pembagi_ppn,
        $no_sp, $tgl_input, $inc_ppn, $suplier, $id_suplier, $id_sp, $no_faktur, $akun_biaya1, $akun_biaya2, $akun_bayar, $no_faktur_pajak, $tgl_faktur_pajak, $kompensasi_pajak, $keterangan,
        $subtotal = 0, $diskon = 0, $hasil_diskon, $dpp = 0, $ppn = 0, $biaya1 = 0, $biaya2 = 0, $total_tagihan = 0, $jumlah_bayar = 0, $total_hutang,
        $isDataSaved, $no_reff;

    public $id, $produk_pembelian, $akses, $suratPesanan, $pesanans;

    public $akuns = [], $akuns2 = [];

    public function updatedSuratPesanan($id_surat)
    {
        $sp = SPPembelian::find($id_surat);
        $this->surat = $sp;
        $this->no_sp = $sp->no_sp;
        $this->suplier = $sp->suplier->nama_suplier;
        $this->id_suplier = $sp->suplier->id;
        $this->id_sp = $id_surat;
    }

    #[On('insertProduk')]
    public function getProduk($id_surat)
    {
        $sp = SPPembelian::find($id_surat);
        $this->surat = $sp;
        $this->no_sp = $sp->no_sp;
        $this->suplier = $sp->suplier->nama_suplier;
        $this->id_sp = $id_surat;
    }

    public function calculateTotal($index)
    {
        $order = $this->counts[$index];
        $qty = $order['qty'] ?? 0;
        $harga = $order['harga'] ?? 0;
        $disc1 = isset($order['disc1']) && is_numeric($order['disc1']) ? $order['disc1'] : 0;
        $disc2 = isset($order['disc2']) && is_numeric($order['disc2']) ? $order['disc2'] : 0;
        $harga_qty = $qty * str_replace('.', '', $harga);
        $total_awal = $harga_qty - ($harga_qty * $disc1 / 100);
        $total_akhir = $total_awal - ($total_awal * $disc2 / 100);
        $this->counts[$index]['total'] = $total_akhir;

        $this->subtotal = 0;
        foreach ($this->counts as $order) {
            $this->subtotal += round($order['total'] ?? 0);
        }

        $this->updatedDiskon();
        $this->updatedBiaya1();
        $this->updatedBiaya2();
        $this->updatedJumlahBayar();
    }

    public function updatedIncPpn()
    {
        $this->updatedDiskon();
    }

    public function updatedDiskon()
    {
        $ppn = PPN::where('id', Auth::user()->id_perusahaan)->first()->ppn;
        $this->hasil_diskon = round($this->subtotal * ((isset($this->diskon) && is_numeric($this->diskon) ? $this->diskon : 0) / 100));
        if ($this->inc_ppn) {
            $this->dpp = round(($this->subtotal - $this->hasil_diskon) / (1 + ($ppn / 100)));
        } else {
            $this->dpp = round($this->subtotal - $this->hasil_diskon);
        }
        $this->ppn = round($this->dpp * ($ppn / 100));
        $this->updatedBiaya1();
        $this->updatedBiaya2();
        $this->updatedJumlahBayar();
    }

    public function updatedBiaya1()
    {
        $this->total_tagihan = $this->dpp + $this->ppn + str_replace('.', '', $this->biaya1) + str_replace('.', '', $this->biaya2);
    }

    public function updatedBiaya2()
    {
        $this->updatedBiaya1();
    }

    public function updatedJumlahBayar()
    {
        $this->total_hutang = $this->total_tagihan - str_replace('.', '', $this->jumlah_bayar);
    }

    public function updated($field)
    {
        if (strpos($field, 'counts') === 0) {
            $index = explode('.', $field)[1];
            $this->calculateTotal($index);
        }
    }

    public function mount()
    {
        $this->pesanans = SPPembelian::where('id_perusahaan', Auth::user()->id_perusahaan)
            ->whereNotIn('id', Pembelian::pluck('id_sp')->toArray())
            ->get();
        $this->tgl_faktur = now()->toDateString();
        $this->tgl_input = now()->toDateString();
        $this->akuns = AkunAkutansi::where('id_perusahaan', Auth::user()->id_perusahaan)->get();
        $this->akuns2 = AkunAkutansi::where('kode', 'LIKE', '%8-%')->get();

        // Ambil nomor urutan terakhir dari database
        $lastOrder = Pembelian::latest()->first();

        if ($lastOrder) {
            // Jika ada data terakhir, ambil nomor urutan dari referensi dan tambahkan 1
            $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
            $nextOrderNumber = intval($lastOrderNumber) + 1;
        } else {
            // Jika tidak ada data sebelumnya, mulai dengan nomor 1
            $nextOrderNumber = 1;
        }

        // Format nomor urutan dengan str_pad
        $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
        $this->no_reff = $urutan . '/BL/' . date('m-y');


        if ($this->id) {
            $pembelian = Pembelian::find($this->id);
            $this->surat = SPPembelian::find($pembelian->id_sp);
            $this->produk_pembelian = ProdukPembelian::where('id_pembelian', $this->id)->get();
            $this->id_sp = $pembelian->id_sp;
            $this->no_reff = $pembelian->no_reff;
            $this->no_sp = $pembelian->no_sp;
            $this->tgl_input = $pembelian->tgl_input;
            $this->suplier = Suplier::find($pembelian->suplier)->nama_suplier;
            $this->id_suplier = $pembelian->suplier;
            $this->no_faktur = $pembelian->no_faktur;
            $this->inc_ppn = $pembelian->inc_ppn == 1 ? true : false;
            $this->active = $pembelian->kredit == 1 ? true : false;
            $this->hari = $pembelian->jumlah_hari;
            $this->tgl_tempo_kredit = $pembelian->tempo_kredit;
            $this->disabled = $pembelian->kredit == 1 ? '' : 'disabled';
            $this->total_hutang = str_replace('.', '', $pembelian->total_tagihan) - str_replace('.', '', $pembelian->jumlah_bayar);
            $this->subtotal = $pembelian->subtotal;
            $this->diskon = $pembelian->diskon;
            $this->hasil_diskon = $pembelian->hasil_diskon;
            $this->dpp = $pembelian->dpp;
            $this->ppn = $pembelian->ppn;
            $this->biaya1 = $pembelian->biaya1;
            $this->biaya2 = $pembelian->biaya2;
            $this->akun_biaya1 = $pembelian->akun_biaya1;
            $this->akun_biaya2 = $pembelian->akun_biaya2;
            $this->total_tagihan = $pembelian->total_tagihan;
            $this->akun_bayar = $pembelian->akun_bayar;
            $this->jumlah_bayar = $pembelian->jumlah_bayar;
            $this->no_faktur_pajak = $pembelian->no_faktur_pajak;
            $this->no_faktur_pajak = $pembelian->no_faktur_pajak;
            $this->tgl_faktur_pajak = $pembelian->tgl_faktur_pajak;
            $this->kompensasi_pajak = $pembelian->kompensasi_pajak;
            $this->keterangan = $pembelian->keterangan;
            foreach ($this->produk_pembelian as $index => $prod) {
                $this->counts[$index]['qty'] = $prod['qty_faktur'];
                $this->counts[$index]['harga'] = $prod['harga'];
                $this->counts[$index]['disc1'] = $prod['disc_1'];
                $this->counts[$index]['disc2'] = $prod['disc_2'];
                $this->counts[$index]['total'] = $prod['total'];
            }
        }
    }

    public function render()
    {
        return view('livewire.pembelian.tambah-pembelian');
    }

    public function updatedActive()
    {
        $this->disabled = $this->active ? '' : 'disabled';
    }

    public function updatedHari()
    {
        $this->tgl_tempo_kredit =  date('Y-m-d', strtotime($this->tgl_faktur . ' + ' . $this->hari . ' days'));
    }

    public function updatedTglTempoKredit()
    {
        $diff = strtotime($this->tgl_tempo_kredit) - strtotime($this->tgl_faktur);
        $this->hari = $diff / 60 / 60 / 24;
    }

    public function buatPembelian()
    {
        if ($this->total_hutang != 0 && $this->active != true && $this->hari == '') {
            session()->flash('error', 'Total hutang masih tersedia, sedangakan kredit tidak di centang dan tersetting');
        } elseif ($this->surat == null) {
            $this->js("alert('Pilih surat pesanan terlebih dahulu')");
        } elseif ($this->total_hutang < 0) {
            $this->js("alert('Jumlah bayar yang anda masukan melebihi total bayar')");
        } else {
            //untuk tambah data
            if (!$this->id) {
                $lastOrder = Pembelian::latest()->first();

                if ($lastOrder) {
                    $lastOrderNumber = explode('/', $lastOrder->no_reff)[0];
                    $nextOrderNumber = intval($lastOrderNumber) + 1;
                } else {
                    $nextOrderNumber = 1;
                }

                $urutan = str_pad($nextOrderNumber, 6, '0', STR_PAD_LEFT);
                $simpan = $pembelian = Pembelian::create([
                    'id_perusahaan' => Auth::user()->id_perusahaan,
                    'id_sp' => $this->id_sp,
                    'no_reff' => $urutan . '/BL/' . date('m-y'),
                    'no_sp' => $this->no_sp,
                    'tgl_input' => $this->tgl_input,
                    'tgl_faktur' => $this->tgl_faktur,
                    'inc_ppn' => $this->inc_ppn ? 1 : 0,
                    'suplier' => $this->id_suplier,
                    'no_faktur' => $this->no_faktur,
                    'kredit' => $this->active ? 1 : 0,
                    'jumlah_hari' => $this->hari,
                    'tempo_kredit' => $this->tgl_tempo_kredit,
                    'subtotal' => $this->subtotal,
                    'diskon' => $this->diskon ?? 0,
                    'hasil_diskon' => $this->hasil_diskon,
                    'dpp' => $this->dpp,
                    'ppn' => $this->ppn,
                    'biaya1' => $this->biaya1,
                    'akun_biaya1' => $this->akun_biaya1,
                    'biaya2' => $this->biaya2,
                    'akun_biaya2' => $this->akun_biaya2,
                    'total_tagihan' => $this->total_tagihan,
                    'akun_bayar' => $this->akun_bayar,
                    'jumlah_bayar' => $this->jumlah_bayar ?? 0,
                    'no_faktur_pajak' => $this->no_faktur_pajak ?? '-',
                    'tgl_faktur_pajak' => $this->tgl_faktur_pajak ?? "-",
                    'kompensasi_pajak' => $this->kompensasi_pajak ?? "-",
                    'keterangan' => $this->keterangan ?? '-',
                ]);
                // if (str_replace('.', '', $this->total_tagihan) - str_replace('.', '', $this->jumlah_bayar) != 0) {
                //     $simpan->hutang_pengguna()->create([
                //         'id_perusahaan' => Auth::user()->id_perusahaan,
                //         'id_pembelian' => $simpan->id,
                //         'sumber' => 'pembelian',
                //         'detailable_type' => Pembelian::class,
                //         'detailable_id' => $simpan->id,
                //         'id_suplier' => $this->id_suplier,
                //         'nominal_bayar' => $this->jumlah_bayar ?? 0,
                //         'total_hutang' => str_replace('.', '', $this->total_tagihan) - str_replace('.', '', $this->jumlah_bayar),
                //         'sisa_hutang' => str_replace('.', '', $this->total_tagihan) - str_replace('.', '', $this->jumlah_bayar)
                //     ]);       
                // }

                if ($simpan) {

                    //get data isi
                    $RencanaOrder = RencanaOrder::whereIn('id', json_decode($this->surat->id_order))->get();
                    $totalIsi = 0;
                    foreach ($this->counts as $index => $order) {
                        $totalIsi += $RencanaOrder[$index]->produk->isi * $order['qty'];
                    }

                    $pengurang = round($this->hasil_diskon / $totalIsi, 5);
                    $produk = explode(',', $this->surat->id_order);
                    foreach ($this->counts as $index => $order) {
                        $hppFinal = round($order['total'] / $order['qty'] / $RencanaOrder[$index]->produk->isi, 5);
                        $hppFinalPembelian = $hppFinal - $pengurang;
                        ProdukPembelian::create([
                            'id_perusahaan' => Auth::user()->id_perusahaan,
                            'id_pembelian' => $pembelian->id,
                            'id_sp' => $this->id_sp,
                            'id_produk' => $RencanaOrder[$index]->id_produk,
                            'id_order' => intval(trim($produk[$index], '[]"')),
                            'qty_faktur' => $order['qty'],
                            'harga' => $order['harga'],
                            'disc_1' => $order['disc1'] ?? 0,
                            'disc_2' => $order['disc2'] ?? 0,
                            'total' => $order['total'],
                            'hpp_final' => $hppFinalPembelian,
                        ]);
                    }
                }

                session()->flash('success', 'Data berhasil disimpan!');
                return redirect('pembelian');
            } else {
                //untuk edit data
                $pembelian = Pembelian::find($this->id);
                $simpan = $pembelian->update([
                    'id_sp' => $this->id_sp,
                    'no_sp' => $this->no_sp,
                    'tgl_input' => $this->tgl_input,
                    'tgl_faktur' => $this->tgl_faktur,
                    'inc_ppn' => $this->inc_ppn ? 1 : 0,
                    'suplier' => $this->id_suplier,
                    'no_faktur' => $this->no_faktur,
                    'kredit' => $this->active ? 1 : 0,
                    'jumlah_hari' => $this->hari,
                    'tempo_kredit' => $this->tgl_tempo_kredit,
                    'subtotal' => $this->subtotal,
                    'diskon' => $this->diskon ?? 0,
                    'hasil_diskon' => $this->hasil_diskon,
                    'dpp' => $this->dpp,
                    'ppn' => $this->ppn,
                    'biaya1' => $this->biaya1,
                    'akun_biaya1' => $this->akun_biaya1,
                    'biaya2' => $this->biaya2,
                    'akun_biaya2' => $this->akun_biaya2,
                    'total_tagihan' => $this->total_tagihan,
                    'akun_bayar' => $this->akun_bayar,
                    'jumlah_bayar' => $this->jumlah_bayar ?? 0,
                    'no_faktur_pajak' => $this->no_faktur_pajak ?? '-',
                    'tgl_faktur_pajak' => $this->tgl_faktur_pajak ?? "-",
                    'kompensasi_pajak' => $this->kompensasi_pajak ?? "-",
                    'keterangan' => $this->keterangan ?? '-',
                ]);
                if ($simpan) {
                    if (str_replace('.', '', $pembelian->total_tagihan) - str_replace('.', '', $pembelian->jumlah_bayar) != 0) {
                        $hutang = HutangPengguna::where('sourceable_type', Pembelian::class)->where('sourceable_id', $this->id)
                            ->where('detailable_type', Pembelian::class)->where('detailable_id', $this->id)
                            ->latest()->first();
                        if ($hutang->no_reff == null)
                            $hutang->update([
                                'id_pembelian' => $this->id,
                                'id_suplier' => $this->id_suplier,
                                'nominal_bayar' => str_replace('.', '', $pembelian->jumlah_bayar),
                                'total_hutang' => str_replace('.', '', $pembelian->total_tagihan) - str_replace('.', '', $pembelian->jumlah_bayar),
                                'sisa_hutang' => str_replace('.', '', $pembelian->total_tagihan) - str_replace('.', '', $pembelian->jumlah_bayar)
                            ]);
                    }
                    $RencanaOrder = RencanaOrder::whereIn('id', json_decode($this->surat->id_order))->get();
                    $totalIsi = 0;
                    foreach ($this->counts as $index => $order) {
                        $totalIsi += $RencanaOrder[$index]->produk->isi * $order['qty'];
                    }
                    $pengurang = round($this->hasil_diskon / $totalIsi, 5);

                    $produk = explode(',', $this->surat->id_order);

                    foreach ($this->counts as $index => $order) {
                        $hppFinal = round($order['total'] / $order['qty'] / $RencanaOrder[$index]->produk->isi, 5);
                        $hppFinalPembelian = $hppFinal - $pengurang;

                        $produkPembelian = ProdukPembelian::where('id_pembelian', $pembelian->id)
                            ->where('id_order', $produk[$index])
                            ->first();

                        if ($produkPembelian) {
                            $produkPembelian->qty_faktur = $order['qty'];
                            $produkPembelian->harga = $order['harga'];
                            $produkPembelian->disc_1 = $order['disc1'] ?? 0;
                            $produkPembelian->disc_2 = $order['disc2'] ?? 0;
                            $produkPembelian->total = $order['total'];
                            $produkPembelian->hpp_final = $hppFinalPembelian;
                            $produkPembelian->save();
                        }
                    }

                    //persediaan dagang dan konsi
                    Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                        ->where('kode_akun', AkunAkutansi::find(3)->kode)->update([
                            'debet' => $this->dpp,
                        ]);
                    //PPN masukan
                    Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                        ->where('kode_akun', AkunAkutansi::find(5)->kode)->update([
                            'debet' => $this->ppn,
                        ]);

                    if ($this->akun_bayar) {
                        //Kas bank
                        if (Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                            ->where('kode_akun', AkunAkutansi::find($this->akun_bayar)->kode)->first()
                        ) {
                            Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                                ->where('kode_akun', AkunAkutansi::find($this->akun_bayar)->kode)->update([
                                    'kredit' => $this->jumlah_bayar,
                                ]);
                            //hutang dagang dan konsi
                            Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                                ->where('kode_akun', AkunAkutansi::find(6)->kode)->update([
                                    'kredit' => $this->total_tagihan - $this->jumlah_bayar,
                                ]);
                        } else {
                            //Kas bank
                            Jurnal::create([
                                'id_perusahaan' => Auth::user()->id_perusahaan,
                                'no_reff' =>  $pembelian->no_reff,
                                'kode_akun' => AkunAkutansi::find($this->akun_bayar)->kode,
                                'id_sumber' => $this->id,
                                'sumber' => 'Pembelian',
                                'keterangan' => 'Pembelian',
                                'kredit' => $this->jumlah_bayar,
                            ]);

                            //hutang dagang dan konsi
                            Jurnal::create([
                                'id_perusahaan' => Auth::user()->id_perusahaan,
                                'no_reff' =>  $pembelian->no_reff,
                                'kode_akun' => AkunAkutansi::find(6)->kode,
                                'id_sumber' => $this->id,
                                'sumber' => 'Pembelian',
                                'keterangan' => 'Pembelian',
                                'kredit' => $this->total_tagihan - $this->jumlah_bayar,
                            ]);
                        }
                    }

                    if ($this->biaya1) {
                        //hutang dagang dan konsi
                        if (Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                            ->where('kode_akun', AkunAkutansi::find($this->akun_biaya1)->kode)->first()
                        ) {
                            Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                                ->where('kode_akun', AkunAkutansi::find($this->akun_biaya1)->kode)->update([
                                    'debet' => $this->biaya1,
                                ]);
                        } else {
                            //hutang dagang dan konsi
                            Jurnal::create([
                                'id_perusahaan' => Auth::user()->id_perusahaan,
                                'no_reff' =>  $pembelian->no_reff,
                                'kode_akun' => AkunAkutansi::find($this->akun_biaya1)->kode,
                                'id_sumber' => $this->id,
                                'sumber' => 'Pembelian',
                                'keterangan' => 'Pembelian',
                                'debet' => $this->biaya1,
                            ]);
                        }
                    }

                    if ($this->biaya2) {
                        if (Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                            ->where('kode_akun', AkunAkutansi::find($this->akun_biaya2)->kode)->first()
                        ) {
                            //hutang dagang dan konsi
                            Jurnal::where('no_reff', $pembelian->no_reff)->where('id_perusahaan', Auth::user()->id_perusahaan)->where('id_sumber', $pembelian->id)->where('sumber', 'Pembelian')
                                ->where('kode_akun', AkunAkutansi::find($this->akun_biaya2)->kode)->update([
                                    'debet' => $this->biaya2,
                                ]);
                        } else {
                            //hutang dagang dan konsi
                            Jurnal::create([
                                'id_perusahaan' => Auth::user()->id_perusahaan,
                                'no_reff' =>  $pembelian->no_reff,
                                'kode_akun' => AkunAkutansi::find($this->akun_biaya2)->kode,
                                'id_sumber' => $this->id,
                                'sumber' => 'Pembelian',
                                'keterangan' => 'Pembelian',
                                'debet' => $this->biaya2,
                            ]);
                        }
                    }

                    session()->flash('success', 'Data berhasil diedit!');
                    return redirect('pembelian');
                }
            }
        }
    }
}
